<?php
namespace Tests\Feature\Api;
use App\Models\BlogPost;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class BlogTest extends TestCase {
    use RefreshDatabase;

    private function makePost(array $attrs = []): BlogPost {
        $author = Instructor::factory()->create();
        return BlogPost::factory()->create(array_merge(['author_id' => $author->id, 'is_published' => true], $attrs));
    }

    public function test_anyone_can_list_published_posts(): void {
        $this->makePost();
        $this->makePost(['is_published' => false]);
        $response = $this->getJson('/api/blog');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json());
    }

    public function test_response_shape_matches_frontend_blog_type(): void {
        $this->makePost();
        $post = $this->getJson('/api/blog')->json()[0];
        foreach (['id','title','slug','excerpt','content','thumbnail','author','tags','category','publishedAt','readingTime','isPublished'] as $key) {
            $this->assertArrayHasKey($key, $post, "Missing key: {$key}");
        }
        $this->assertArrayHasKey('name', $post['author']);
    }

    public function test_can_get_post_by_id(): void {
        $post = $this->makePost();
        $this->getJson("/api/blog/{$post->id}")->assertStatus(200)->assertJsonPath('id', (string) $post->id);
    }

    public function test_can_get_post_by_slug(): void {
        $post = $this->makePost();
        $this->getJson("/api/blog/by-slug/{$post->slug}")->assertStatus(200)->assertJsonPath('slug', $post->slug);
    }

    public function test_admin_can_create_post(): void {
        $admin = User::factory()->create(['role' => 'admin']);
        $author = Instructor::factory()->create();
        $payload = ['title'=>'New Post','excerpt'=>'Short.','content'=>'Long content.','category'=>'Tech','author_id'=>$author->id,'is_published'=>true];
        $this->actingAs($admin)->postJson('/api/blog', $payload)->assertStatus(201)->assertJsonPath('title', 'New Post');
    }

    public function test_non_admin_cannot_create_post(): void {
        $user = User::factory()->create(['role' => 'student']);
        $author = Instructor::factory()->create();
        $this->actingAs($user)->postJson('/api/blog', ['title'=>'X','excerpt'=>'X','content'=>'X','category'=>'X','author_id'=>$author->id])->assertStatus(403);
    }

    public function test_admin_can_delete_post(): void {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = $this->makePost();
        $this->actingAs($admin)->deleteJson("/api/blog/{$post->id}")->assertStatus(200);
        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }
}
