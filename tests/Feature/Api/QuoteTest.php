<?php
namespace Tests\Feature\Api;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class QuoteTest extends TestCase {
    use RefreshDatabase;
    public function test_anyone_can_list_active_quotes(): void {
        Quote::factory()->count(3)->create(['is_active'=>true]);
        Quote::factory()->create(['is_active'=>false]);
        $this->getJson('/api/quotes')->assertStatus(200)->assertJsonCount(3,'data');
    }
    public function test_can_get_featured_quotes(): void {
        Quote::factory()->count(2)->create(['is_active'=>true,'is_featured'=>true]);
        Quote::factory()->create(['is_active'=>true,'is_featured'=>false]);
        $this->getJson('/api/quotes/featured')->assertStatus(200)->assertJsonCount(2,'data');
    }
    public function test_can_get_random_quote(): void {
        Quote::factory()->create(['is_active'=>true]);
        $this->getJson('/api/quotes/random')->assertStatus(200)->assertJsonStructure(['data'=>['id','content']]);
    }
    public function test_random_returns_404_when_no_quotes(): void {
        $this->getJson('/api/quotes/random')->assertStatus(404);
    }
    public function test_can_show_single_quote(): void {
        $quote = Quote::factory()->create(['is_active'=>true]);
        $this->getJson("/api/quotes/{$quote->id}")->assertStatus(200)->assertJsonPath('data.id',$quote->id);
    }
    public function test_authenticated_user_can_create_quote(): void {
        $user = User::factory()->create();
        $this->actingAs($user)->postJson('/api/quotes',['content'=>'A wise saying.','language'=>'en'])->assertStatus(201)->assertJsonFragment(['content'=>'A wise saying.']);
        $this->assertDatabaseHas('quotes',['content'=>'A wise saying.']);
    }
    public function test_unauthenticated_user_cannot_create_quote(): void {
        $this->postJson('/api/quotes',['content'=>'Unauthorized quote.'])->assertStatus(401);
    }
    public function test_authenticated_user_can_update_quote(): void {
        $user = User::factory()->create();
        $quote = Quote::factory()->create();
        $this->actingAs($user)->putJson("/api/quotes/{$quote->id}",['content'=>'Updated content.'])->assertStatus(200)->assertJsonFragment(['content'=>'Updated content.']);
    }
    public function test_authenticated_user_can_delete_quote(): void {
        $user = User::factory()->create();
        $quote = Quote::factory()->create();
        $this->actingAs($user)->deleteJson("/api/quotes/{$quote->id}")->assertStatus(200);
        $this->assertDatabaseMissing('quotes',['id'=>$quote->id]);
    }
}
