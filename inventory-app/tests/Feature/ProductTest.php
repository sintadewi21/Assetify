<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $staff;
    private User $manager;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users with different roles
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->staff = User::factory()->create(['role' => 'staff']);
        $this->manager = User::factory()->create(['role' => 'manager']);

        // Create a test category
        $this->category = Category::create(['name' => 'Elektronik']);
    }

    /** @test */
    public function guest_users_cannot_access_products()
    {
        $response = $this->get(route('products.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_can_view_products_list()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'code' => 'PROD-001',
            'name' => 'Test Laptop',
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus'
        ]);

        $response = $this->actingAs($this->admin)->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertSee('Test Laptop');
        $response->assertSee('PROD-001');
    }

    /** @test */
    public function staff_can_view_products_list()
    {
        $response = $this->actingAs($this->staff)->get(route('products.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function manager_cannot_access_products_crud()
    {
        $response = $this->actingAs($this->manager)->get(route('products.index'));
        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function admin_can_create_product()
    {
        $productData = [
            'category_id' => $this->category->id,
            'code' => 'PROD-002',
            'name' => 'Printer HP',
            'stock' => 5,
            'location' => 'Gudang B',
            'condition' => 'Bagus'
        ];

        $response = $this->actingAs($this->admin)->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'code' => 'PROD-002',
            'name' => 'Printer HP'
        ]);
    }

    /** @test */
    public function product_creation_requires_validation()
    {
        $invalidData = [
            'category_id' => '',
            'code' => '',
            'name' => '',
            'stock' => -1,
            'location' => '',
            'condition' => 'invalid-condition'
        ];

        $response = $this->actingAs($this->admin)->post(route('products.store'), $invalidData);

        $response->assertSessionHasErrors(['category_id', 'code', 'name', 'stock', 'location', 'condition']);
    }

    /** @test */
    public function product_code_must_be_unique()
    {
        Product::create([
            'category_id' => $this->category->id,
            'code' => 'UNIQUE-101',
            'name' => 'Product 1',
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus'
        ]);

        $duplicateData = [
            'category_id' => $this->category->id,
            'code' => 'UNIQUE-101', // duplicate
            'name' => 'Product 2',
            'stock' => 5,
            'location' => 'Gudang B',
            'condition' => 'Bagus'
        ];

        $response = $this->actingAs($this->admin)->post(route('products.store'), $duplicateData);
        $response->assertSessionHasErrors(['code']);
    }

    /** @test */
    public function admin_can_update_product()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'code' => 'PROD-003',
            'name' => 'Mouse Logitech',
            'stock' => 15,
            'location' => 'Gudang C',
            'condition' => 'Bagus'
        ]);

        $updatedData = [
            'category_id' => $this->category->id,
            'code' => 'PROD-003',
            'name' => 'Mouse Logitech Wireless',
            'stock' => 12,
            'location' => 'Gudang C - Rak 2',
            'condition' => 'Rusak Ringan'
        ];

        $response = $this->actingAs($this->admin)->put(route('products.update', $product), $updatedData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Mouse Logitech Wireless',
            'stock' => 12,
            'condition' => 'Rusak Ringan'
        ]);
    }

    /** @test */
    public function admin_can_delete_product()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'code' => 'PROD-004',
            'name' => 'Keyboard Mechanical',
            'stock' => 3,
            'location' => 'Gudang D',
            'condition' => 'Bagus'
        ]);

        $response = $this->actingAs($this->admin)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
