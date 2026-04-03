<?php
namespace Tests\Feature\Api;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AuthTest extends TestCase {
    use RefreshDatabase;

    public function test_user_can_register(): void {
        $response = $this->postJson('/api/auth/register', ['name'=>'Test User','email'=>'test@example.com','password'=>'password123','password_confirmation'=>'password123']);
        $response->assertStatus(201)->assertJsonStructure(['message','user','token']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'role' => 'student']);
    }

    public function test_registration_requires_unique_email(): void {
        User::factory()->create(['email' => 'existing@example.com']);
        $this->postJson('/api/auth/register', ['name'=>'A','email'=>'existing@example.com','password'=>'password123','password_confirmation'=>'password123'])->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    public function test_user_can_login(): void {
        User::factory()->create(['email' => 'login@example.com']);
        $this->postJson('/api/auth/login', ['email'=>'login@example.com','password'=>'password'])->assertStatus(200)->assertJsonStructure(['message','user','token']);
    }

    public function test_login_fails_with_wrong_password(): void {
        User::factory()->create(['email' => 'user@example.com']);
        $this->postJson('/api/auth/login', ['email'=>'user@example.com','password'=>'wrongpassword'])->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    public function test_authenticated_user_can_logout(): void {
        $user = User::factory()->create();
        $this->actingAs($user)->postJson('/api/auth/logout')->assertStatus(200);
    }

    public function test_unauthenticated_request_returns_401(): void {
        $this->getJson('/api/auth/me')->assertStatus(401);
    }

    public function test_me_returns_user_with_enrolled_courses(): void {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/auth/me');
        $response->assertStatus(200)->assertJsonPath('user.email', $user->email)->assertJsonPath('user.role', $user->role);
        $this->assertArrayHasKey('enrolledCourses', $response->json('user'));
    }

    public function test_user_resource_matches_frontend_user_type(): void {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/auth/me');
        $userData = $response->json('user');
        foreach (['id','name','email','role','enrolledCourses','createdAt'] as $key) {
            $this->assertArrayHasKey($key, $userData, "Missing key: {$key}");
        }
    }
}
