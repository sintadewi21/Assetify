<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'admin']);
        $this->category = Category::create(['name' => 'Elektronik']);
    }

    /** @test */
    public function can_get_categories_via_api()
    {
        $response = $this->actingAs($this->user)->get('/api/categories');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Daftar kategori berhasil diambil'
        ]);
    }

    /** @test */
    public function can_get_products_list_via_api()
    {
        Product::create([
            'category_id' => $this->category->id,
            'code' => 'PROD-API-01',
            'name' => 'Mouse API',
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus'
        ]);

        $response = $this->actingAs($this->user)->get('/api/products?search=Mouse');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Mouse API']);
    }

    /** @test */
    public function can_show_single_product_via_api()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'code' => 'PROD-API-02',
            'name' => 'Keyboard API',
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus'
        ]);

        $response = $this->actingAs($this->user)->get('/api/products/' . $product->id);
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Keyboard API']);

        // Test show non-existent product
        $response = $this->actingAs($this->user)->get('/api/products/999');
        $response->assertStatus(404);
    }

    /** @test */
    public function can_create_product_via_api()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('product.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->user)->postJson('/api/products', [
            'category_id' => $this->category->id,
            'code' => 'PROD-API-03',
            'name' => 'Monitor API',
            'stock' => 5,
            'location' => 'Gudang B',
            'condition' => 'Bagus',
            'image' => $file
        ]);

        $response->assertStatus(210); // Returns 210 in API controller on success
        $this->assertDatabaseHas('products', ['code' => 'PROD-API-03']);
        
        // Test fails validation
        $response = $this->actingAs($this->user)->postJson('/api/products', []);
        $response->assertStatus(422);
    }

    /** @test */
    public function can_update_product_via_api()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'code' => 'PROD-API-04',
            'name' => 'Laptop API',
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus'
        ]);

        $response = $this->actingAs($this->user)->putJson('/api/products/' . $product->id, [
            'category_id' => $this->category->id,
            'code' => 'PROD-API-04',
            'name' => 'Laptop API Updated',
            'stock' => 8,
            'location' => 'Gudang A',
            'condition' => 'Bagus'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'Laptop API Updated']);

        // Test update non-existent product
        $response = $this->actingAs($this->user)->putJson('/api/products/999', []);
        $response->assertStatus(404);

        // Test validation fails
        $response = $this->actingAs($this->user)->putJson('/api/products/' . $product->id, []);
        $response->assertStatus(422);
    }

    /** @test */
    public function can_delete_product_via_api()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'code' => 'PROD-API-05',
            'name' => 'Cable API',
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus'
        ]);

        $response = $this->actingAs($this->user)->delete('/api/products/' . $product->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);

        // Test delete non-existent product
        $response = $this->actingAs($this->user)->delete('/api/products/999');
        $response->assertStatus(404);
    }

    /** @test */
    public function can_get_loans_via_api()
    {
        $response = $this->actingAs($this->user)->get('/api/loans');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Daftar transaksi peminjaman berhasil diambil'
        ]);
    }

    /** @test */
    public function can_store_loans_via_api()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'code' => 'PROD-LOAN-01',
            'name' => 'Chair API',
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus'
        ]);

        $response = $this->actingAs($this->user)->postJson('/api/loans', [
            'user_id' => $this->user->id,
            'borrower_name' => 'John Doe',
            'borrow_date' => now()->format('Y-m-d'),
            'products' => [
                [
                    'product_id' => $product->id,
                    'qty' => 2
                ]
            ]
        ]);

        $response->assertStatus(210); // Returns 210 in API Controller on success
        $this->assertDatabaseHas('borrowings', ['borrower_name' => 'John Doe']);
        
        // Test fails validation
        $response = $this->actingAs($this->user)->postJson('/api/loans', []);
        $response->assertStatus(422);

        // Test stock insufficient
        $response = $this->actingAs($this->user)->postJson('/api/loans', [
            'user_id' => $this->user->id,
            'borrower_name' => 'John Doe Fail',
            'borrow_date' => now()->format('Y-m-d'),
            'products' => [
                [
                    'product_id' => $product->id,
                    'qty' => 50
                ]
            ]
        ]);
        $response->assertStatus(400);
    }
}
