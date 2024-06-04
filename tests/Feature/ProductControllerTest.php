<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function test_api_returns_products_list()
    {
        $products = Product::factory(10)->create(['created_at' => now()->format('Y-m-d H:i'), 'updated_at' => now()->format('Y-m-d H:i'), 'refresh' => now()->format('Y-m-d H:i')]);
        $response = $this->getJson(route('api.list.products'))
        ->assertStatus(200);
        foreach ($products as $product) {
            $response->assertJsonFragment([
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'latitude' => $product->latitude,
                'longitude' => $product->longitude,
                'refresh' => $product->refresh->format('Y-m-d H:i'),
                'address' => $product->address,
                'category_id' => $product->category_id,
                'user_id' => $product->user_id,
                'created_at' => $product->created_at->format('Y-m-d H:i'),
                'updated_at' => $product->updated_at->format('Y-m-d H:i'),
            ]);
        }
        $this->assertDatabaseCount('products', 10);
    }
    /**
     * @test
     */
    public function test_api_product_store_successfull()
    {
        $product = Product::factory()->make(['created_at' => now()->format('Y-m-d H:i'), 'updated_at' => now()->format('Y-m-d H:i'), 'refresh' => now()->format('Y-m-d H:i')])->toArray();
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson(route('api.create.product'), $product)
        ->assertStatus(201);
        $this->assertDatabaseCount('products', 1);
        $response->assertJsonFragment([
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'latitude' => $product['latitude'],
            'longitude' => $product['longitude'],
            'refresh' => (new Carbon($product['refresh']))->format('Y-m-d H:i'),
            'address' => $product['address'],
            'category_id' => $product['category_id'],
            'user_id' => $user->id,
            'created_at' => (new Carbon($product['created_at']))->setTimezone('Europe/Warsaw')->format('Y-m-d H:i'),
            'updated_at' => (new Carbon($product['updated_at']))->setTimezone('Europe/Warsaw')->format('Y-m-d H:i'),
        ]);
        $this->assertDatabaseHas('products', [
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'latitude' => $product['latitude'],
            'longitude' => $product['longitude'],
            'refresh' => (new Carbon($product['refresh']))->format('Y-m-d H:i:s'),
            'address' => $product['address'],
            'category_id' => $product['category_id'],
            'user_id' => $user->id,
        ]);
    }
    /**
     * @test
     */
    public function test_api_product_store_unsuccessful_user_cant_store_product_without_description()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product=[
            'name' => 'test',
            'price' => 100,
            'user_id' => $user->id,
            'category_id' => 90,
            'refresh' => '2024-05-14 09:08:44',
            'latitude' => 50.30,
            'longitude' => 30.30,
            'address' => 'Kielce'
        ];
        $response = $this->postJson(route('api.create.product'),$product )
        ->assertStatus(422)
        ->assertJsonValidationErrorFor('description');
    }
    /**
     * @test
     */
    public function test_api_product_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->deleteJson(route('api.delete.product',['product' => $product->id]))
        ->assertStatus(204)
        ;
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
        $this->assertDatabaseCount('products', 0);
    }
    /**
     * @test
     */
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
        $response = $this->put(route('api.update.product',['product' => $product->id]),$newData)
        ->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'id' => $user->id,
            'name' => $newData
        ]);
        $this->assertDatabaseCount('products', 1);
    }
    /**
     * @test
     */
    public function test_api_product_show()
    {
        $product = Product::factory()->create(['created_at' => now()->format('Y-m-d H:i'), 'updated_at' => now()->format('Y-m-d H:i'), 'refresh' => now()->format('Y-m-d H:i')]);
        $response = $this->getJson(route('api.show.product', ['product'=>$product->id]))
        ->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'latitude' => $product->latitude,
            'longitude' => $product->longitude,
            'refresh' => $product->refresh->format('Y-m-d H:i'),
            'address' => $product->address,
            'category_id' => $product->category_id,
            'user_id' => $product->user_id,
            'created_at' => $product->created_at->format('Y-m-d H:i'),
            'updated_at' => $product->updated_at->format('Y-m-d H:i'),
        ]);
    }
}
