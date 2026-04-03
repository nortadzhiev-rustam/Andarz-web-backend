<?php
namespace Tests\Feature\Api;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class CategoryTest extends TestCase {
    use RefreshDatabase;
    public function test_anyone_can_list_categories(): void {
        Category::factory()->count(3)->create();
        $this->getJson('/api/categories')->assertStatus(200)->assertJsonCount(3,'data');
    }
    public function test_anyone_can_view_category(): void {
        $category = Category::factory()->create();
        $this->getJson("/api/categories/{$category->id}")->assertStatus(200)->assertJsonPath('data.id',$category->id);
    }
    public function test_admin_can_create_category(): void {
        $admin = User::factory()->create(['role'=>'admin']);
        $this->actingAs($admin)->postJson('/api/categories',['name'=>'Wisdom','description'=>'Wise sayings.'])->assertStatus(201)->assertJsonFragment(['name'=>'Wisdom']);
        $this->assertDatabaseHas('categories',['name'=>'Wisdom']);
    }
    public function test_non_admin_cannot_create_category(): void {
        $user = User::factory()->create(['role'=>'user']);
        $this->actingAs($user)->postJson('/api/categories',['name'=>'Unauthorized'])->assertStatus(403);
    }
    public function test_unauthenticated_cannot_create_category(): void {
        $this->postJson('/api/categories',['name'=>'Unauthorized'])->assertStatus(401);
    }
    public function test_admin_can_update_category(): void {
        $admin = User::factory()->create(['role'=>'admin']);
        $category = Category::factory()->create();
        $this->actingAs($admin)->putJson("/api/categories/{$category->id}",['name'=>'Updated Name'])->assertStatus(200)->assertJsonFragment(['name'=>'Updated Name']);
    }
    public function test_admin_can_delete_category(): void {
        $admin = User::factory()->create(['role'=>'admin']);
        $category = Category::factory()->create();
        $this->actingAs($admin)->deleteJson("/api/categories/{$category->id}")->assertStatus(200);
        $this->assertDatabaseMissing('categories',['id'=>$category->id]);
    }
}
