<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_api_returns_products_list()
    {
        $product = Product::factory()->create();
    $response = $this->getJson('/api/products');
    $response->assertJsonFragment([
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'latitude' => $product->latitude,
        'longitude' => $product->longitude,
        'refresh' => $product->refresh->toJSON(),
        'address' => $product->address,
        'category_id' => $product->category_id,
        'user_id' => $product->user_id,
        'created_at' => $product->created_at->toJSON(),
        'updated_at' => $product->updated_at->toJSON(),
    ]);
    }
    public function test_api_product_store_successful()
    {
        $response = $this->postJson('/api/createproduct', [
            'name' => 'test',
            'description'=> 'test',
            'price' => 100,
            'user_id' =>1,
            'category_id'=> 90,
            'refresh' => '2024-05-14 09:08:44',
            'latitude' => 50.30,
            'longitude' => 30.30,
            'address' => 'Kielce'
        ]);
        $response->assertStatus(200);
    }

    public function test_api_product_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->delete('/api/product/'. $product->id);
       $response->assertStatus(204);
        $this->assertDatabaseMissing('products', [
            'id' =>$product->id,
        ]);
    }
    public function test_api_product_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);
        $newData = [
            'name' => 'zmiana',
        ];
        $response = $this->put('/api/product/'. $product->id, $newData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'id' => $user->id,
            'name' => $newData
        ]);
    }
}
