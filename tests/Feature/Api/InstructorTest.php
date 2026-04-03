<?php
namespace Tests\Feature\Api;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class InstructorTest extends TestCase {
    use RefreshDatabase;

    public function test_anyone_can_list_instructors(): void {
        Instructor::factory()->count(3)->create();
        $this->getJson('/api/instructors')->assertStatus(200)->assertJsonCount(3);
    }

    public function test_anyone_can_view_instructor(): void {
        $instructor = Instructor::factory()->create();
        $this->getJson("/api/instructors/{$instructor->id}")->assertStatus(200)->assertJsonPath('id', (string) $instructor->id);
    }

    public function test_admin_can_create_instructor(): void {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->postJson('/api/instructors', ['name'=>'New Instructor','bio'=>'Expert teacher.'])->assertStatus(201)->assertJsonPath('name', 'New Instructor');
    }

    public function test_non_admin_cannot_create_instructor(): void {
        $user = User::factory()->create(['role' => 'student']);
        $this->actingAs($user)->postJson('/api/instructors', ['name' => 'Hack'])->assertStatus(403);
    }

    public function test_admin_can_update_instructor(): void {
        $admin = User::factory()->create(['role' => 'admin']);
        $instructor = Instructor::factory()->create();
        $this->actingAs($admin)->putJson("/api/instructors/{$instructor->id}", ['name' => 'Updated'])->assertStatus(200)->assertJsonPath('name', 'Updated');
    }

    public function test_admin_can_delete_instructor(): void {
        $admin = User::factory()->create(['role' => 'admin']);
        $instructor = Instructor::factory()->create();
        $this->actingAs($admin)->deleteJson("/api/instructors/{$instructor->id}")->assertStatus(200);
        $this->assertDatabaseMissing('instructors', ['id' => $instructor->id]);
    }
}
