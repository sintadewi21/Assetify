<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $staff;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->staff = User::factory()->create(['role' => 'staff']);
    }

    /** @test */
    public function authenticated_user_can_view_categories()
    {
        $category = Category::create(['name' => 'Elektronik']);
        $response = $this->actingAs($this->admin)->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertSee('Elektronik');
    }

    /** @test */
    public function admin_can_create_category()
    {
        $response = $this->actingAs($this->admin)->get(route('categories.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->post(route('categories.store'), [
            'name' => 'Furniture',
        ]);
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Furniture']);
    }

    /** @test */
    public function category_creation_requires_unique_name()
    {
        Category::create(['name' => 'Elektronik']);
        $response = $this->actingAs($this->admin)->post(route('categories.store'), [
            'name' => 'Elektronik',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function admin_can_edit_category()
    {
        $category = Category::create(['name' => 'Elektronik']);
        $response = $this->actingAs($this->admin)->get(route('categories.edit', $category));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->put(route('categories.update', $category), [
            'name' => 'Elektronik Baru',
        ]);
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Elektronik Baru']);
    }

    /** @test */
    public function admin_can_delete_category_if_unused()
    {
        $category = Category::create(['name' => 'Elektronik']);
        $response = $this->actingAs($this->admin)->delete(route('categories.destroy', $category));
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['name' => 'Elektronik']);
    }

    /** @test */
    public function admin_cannot_delete_category_if_used_by_products()
    {
        $category = Category::create(['name' => 'Elektronik']);
        Product::create([
            'category_id' => $category->id,
            'code' => 'PROD-123',
            'name' => 'Laptop',
            'stock' => 10,
            'location' => 'Gudang A',
            'condition' => 'Bagus',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('categories.destroy', $category));
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['name' => 'Elektronik']);
    }
}
