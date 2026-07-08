<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Loan;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
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
    public function authenticated_user_can_view_dashboard()
    {
        $category = Category::create(['name' => 'Elektronik']);
        $product = Product::create([
            'category_id' => $category->id,
            'code' => 'PROD-LOW',
            'name' => 'Stok Menipis',
            'stock' => 2, // low stock (< 5)
            'location' => 'Gudang A',
            'condition' => 'Bagus',
        ]);

        // Create overdue loan
        $loan = Loan::create([
            'user_id' => $this->staff->id,
            'borrower_name' => 'Andi',
            'borrow_date' => Carbon::yesterday()->subDays(5),
            'due_date' => Carbon::yesterday(),
            'status' => 'Approved',
        ]);
        $loan->details()->create([
            'product_id' => $product->id,
            'qty' => 1,
        ]);

        $response = $this->actingAs($this->admin)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Stok Menipis');

        // Check that the status has been auto-updated to Overdue
        $loan->refresh();
        $this->assertEquals('Overdue', $loan->status);
    }

    /** @test */
    public function authenticated_user_can_send_overdue_reminder()
    {
        $loan = Loan::create([
            'user_id' => $this->staff->id,
            'borrower_name' => 'Budi',
            'borrow_date' => Carbon::yesterday(),
            'due_date' => Carbon::yesterday(),
            'status' => 'Overdue',
        ]);

        $response = $this->actingAs($this->admin)->post(route('loans.remind', $loan));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Reminder notification sent successfully to the staff in charge!');

        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->staff->id,
            'title' => 'Overdue Return Warning',
        ]);
    }
}
