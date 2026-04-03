<?php
namespace Tests\Feature\Api;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class CourseTest extends TestCase {
    use RefreshDatabase;

    private function makePublishedCourse(array $attrs = []): Course {
        $instructor = Instructor::factory()->create();
        return Course::factory()->create(array_merge(['instructor_id' => $instructor->id, 'is_published' => true], $attrs));
    }

    public function test_anyone_can_list_published_courses(): void {
        $this->makePublishedCourse();
        $this->makePublishedCourse();
        $this->makePublishedCourse(['is_published' => false]);
        $response = $this->getJson('/api/courses');
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }

    public function test_response_shape_matches_frontend_course_type(): void {
        $this->makePublishedCourse();
        $response = $this->getJson('/api/courses');
        $response->assertStatus(200);
        $course = $response->json()[0];
        foreach (['id','title','slug','description','shortDescription','thumbnail','price','level','category','tags','instructor','modules','duration','studentsCount','rating','reviewsCount','language','lastUpdated','isPublished','isFeatured'] as $key) {
            $this->assertArrayHasKey($key, $course, "Missing key: {$key}");
        }
        $this->assertArrayHasKey('id', $course['instructor']);
        $this->assertArrayHasKey('name', $course['instructor']);
    }

    public function test_can_filter_courses_by_category(): void {
        $this->makePublishedCourse(['category' => 'Web Development']);
        $this->makePublishedCourse(['category' => 'Design']);
        $response = $this->getJson('/api/courses?category=Design');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json());
        $this->assertSame('Design', $response->json()[0]['category']);
    }

    public function test_can_filter_courses_by_level(): void {
        $this->makePublishedCourse(['level' => 'beginner']);
        $this->makePublishedCourse(['level' => 'advanced']);
        $response = $this->getJson('/api/courses?level=beginner');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json());
        $this->assertSame('beginner', $response->json()[0]['level']);
    }

    public function test_can_get_featured_courses(): void {
        $this->makePublishedCourse(['is_featured' => true]);
        $this->makePublishedCourse(['is_featured' => false]);
        $response = $this->getJson('/api/courses/featured');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json());
    }

    public function test_can_get_course_by_id(): void {
        $course = $this->makePublishedCourse();
        $this->getJson("/api/courses/{$course->id}")->assertStatus(200)->assertJsonPath('id', (string) $course->id);
    }

    public function test_can_get_course_by_slug(): void {
        $course = $this->makePublishedCourse();
        $this->getJson("/api/courses/by-slug/{$course->slug}")->assertStatus(200)->assertJsonPath('slug', $course->slug);
    }

    public function test_authenticated_user_can_enroll_in_course(): void {
        $user = User::factory()->create();
        $course = $this->makePublishedCourse();
        $this->actingAs($user)->postJson("/api/courses/{$course->id}/enroll")
            ->assertStatus(200)->assertJsonFragment(['message' => 'Enrolled successfully.']);
        $this->assertDatabaseHas('course_user', ['user_id' => $user->id, 'course_id' => $course->id]);
    }

    public function test_unauthenticated_user_cannot_enroll(): void {
        $course = $this->makePublishedCourse();
        $this->postJson("/api/courses/{$course->id}/enroll")->assertStatus(401);
    }

    public function test_admin_can_create_course(): void {
        $admin = User::factory()->create(['role' => 'admin']);
        $instructor = Instructor::factory()->create();
        $payload = ['title'=>'New Course','description'=>'Desc','short_description'=>'Short','price'=>49.99,'level'=>'beginner','category'=>'Design','instructor_id'=>$instructor->id,'is_published'=>true,'is_featured'=>false];
        $this->actingAs($admin)->postJson('/api/courses', $payload)->assertStatus(201)->assertJsonPath('title', 'New Course');
        $this->assertDatabaseHas('courses', ['title' => 'New Course']);
    }

    public function test_non_admin_cannot_create_course(): void {
        $user = User::factory()->create(['role' => 'student']);
        $instructor = Instructor::factory()->create();
        $this->actingAs($user)->postJson('/api/courses', ['title'=>'Hack','description'=>'D','short_description'=>'S','price'=>0,'level'=>'beginner','category'=>'X','instructor_id'=>$instructor->id])->assertStatus(403);
    }

    public function test_admin_can_delete_course(): void {
        $admin = User::factory()->create(['role' => 'admin']);
        $course = $this->makePublishedCourse();
        $this->actingAs($admin)->deleteJson("/api/courses/{$course->id}")->assertStatus(200);
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
