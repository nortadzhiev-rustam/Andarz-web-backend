<?php
namespace Tests\Feature\Api;
use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AuthorTest extends TestCase {
    use RefreshDatabase;
    public function test_anyone_can_list_authors(): void {
        Author::factory()->count(3)->create();
        $this->getJson('/api/authors')->assertStatus(200)->assertJsonCount(3,'data');
    }
    public function test_anyone_can_view_author(): void {
        $author = Author::factory()->create();
        $this->getJson("/api/authors/{$author->id}")->assertStatus(200)->assertJsonPath('data.id',$author->id);
    }
    public function test_admin_can_create_author(): void {
        $admin = User::factory()->create(['role'=>'admin']);
        $this->actingAs($admin)->postJson('/api/authors',['name'=>'Rumi','bio'=>'A great Persian poet.'])->assertStatus(201)->assertJsonFragment(['name'=>'Rumi']);
        $this->assertDatabaseHas('authors',['name'=>'Rumi']);
    }
    public function test_non_admin_cannot_create_author(): void {
        $user = User::factory()->create(['role'=>'user']);
        $this->actingAs($user)->postJson('/api/authors',['name'=>'Unauthorized'])->assertStatus(403);
    }
    public function test_admin_can_update_author(): void {
        $admin = User::factory()->create(['role'=>'admin']);
        $author = Author::factory()->create();
        $this->actingAs($admin)->putJson("/api/authors/{$author->id}",['name'=>'Updated Name'])->assertStatus(200)->assertJsonFragment(['name'=>'Updated Name']);
    }
    public function test_admin_can_delete_author(): void {
        $admin = User::factory()->create(['role'=>'admin']);
        $author = Author::factory()->create();
        $this->actingAs($admin)->deleteJson("/api/authors/{$author->id}")->assertStatus(200);
        $this->assertDatabaseMissing('authors',['id'=>$author->id]);
    }
}
