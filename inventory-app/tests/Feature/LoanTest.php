<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Loan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $staff;
    private User $manager;
    private Category $category;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->staff = User::factory()->create(['role' => 'staff']);
        $this->manager = User::factory()->create(['role' => 'manager']);

        // Create category and product
        $this->category = Category::create(['name' => 'Elektronik']);
        $this->product = Product::create([
            'category_id' => $this->category->id,
            'code' => 'TSEL-LP-101',
            'name' => 'MacBook Pro',
            'stock' => 10,
            'location' => 'Lantai 1',
            'condition' => 'Bagus'
        ]);
    }

    /** @test */
    public function guest_users_cannot_access_loans()
    {
        $response = $this->get(route('loans.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_users_can_view_loans_list()
    {
        $response = $this->actingAs($this->staff)->get(route('loans.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function staff_can_record_a_loan_which_reduces_stock_and_sets_pending()
    {
        $loanData = [
            'borrower_name' => 'Budi Santoso',
            'borrow_date' => Carbon::today()->format('Y-m-d'),
            'due_date' => Carbon::tomorrow()->format('Y-m-d'),
            'products' => [
                [
                    'product_id' => $this->product->id,
                    'qty' => 3
                ]
            ]
        ];

        $response = $this->actingAs($this->staff)->post(route('loans.store'), $loanData);

        $response->assertRedirect(route('loans.index'));

        // Check if database recorded the loan as Pending
        $this->assertDatabaseHas('borrowings', [
            'borrower_name' => 'Budi Santoso',
            'status' => 'Pending',
        ]);

        // Check stock reduced (10 - 3 = 7)
        $this->product->refresh();
        $this->assertEquals(7, $this->product->stock);

        // Check notification created for Manager
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->manager->id,
            'title' => 'New Loan Request'
        ]);
    }

    /** @test */
    public function manager_can_approve_pending_loan()
    {
        // 1. Create a pending loan
        $loan = Loan::create([
            'user_id' => $this->staff->id,
            'borrower_name' => 'Rian Wijaya',
            'borrow_date' => Carbon::today(),
            'due_date' => Carbon::tomorrow(),
            'status' => 'Pending'
        ]);

        // 2. Perform approval as Manager
        $response = $this->actingAs($this->manager)->patch(route('loans.approve', $loan));

        $response->assertRedirect(route('loans.index'));
        $loan->refresh();
        $this->assertEquals('Approved', $loan->status);

        // Check notification created for Staff
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->staff->id,
            'title' => 'Loan Request Approved'
        ]);
    }

    /** @test */
    public function manager_can_reject_pending_loan_which_restores_stock()
    {
        // 1. Setup product and reduce stock for loan
        $this->product->decrement('stock', 2); // simulating store behavior

        $loan = Loan::create([
            'user_id' => $this->staff->id,
            'borrower_name' => 'Rian Wijaya',
            'borrow_date' => Carbon::today(),
            'due_date' => Carbon::tomorrow(),
            'status' => 'Pending'
        ]);

        // Detail mapping
        $loan->details()->create([
            'product_id' => $this->product->id,
            'qty' => 2
        ]);

        // 2. Perform rejection as Manager with reason
        $response = $this->actingAs($this->manager)->patch(route('loans.reject', $loan), [
            'reject_reason' => 'Data tidak lengkap'
        ]);

        $response->assertRedirect(route('loans.index'));
        $loan->refresh();
        $this->assertEquals('Rejected', $loan->status);
        $this->assertEquals('Data tidak lengkap', $loan->reject_reason);

        // Check stock is restored to 10
        $this->product->refresh();
        $this->assertEquals(10, $this->product->stock);

        // Check notification created for Staff
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->staff->id,
            'title' => 'Loan Request Rejected'
        ]);
    }

    /** @test */
    public function staff_can_process_return_of_approved_loan_which_restores_stock()
    {
        // 1. Setup approved loan with reduced stock
        $this->product->decrement('stock', 4);

        $loan = Loan::create([
            'user_id' => $this->staff->id,
            'borrower_name' => 'Citra Lestari',
            'borrow_date' => Carbon::today(),
            'due_date' => Carbon::tomorrow(),
            'status' => 'Approved'
        ]);

        $loan->details()->create([
            'product_id' => $this->product->id,
            'qty' => 4
        ]);

        // 2. Process return
        $response = $this->actingAs($this->staff)->patch(route('loans.return', $loan));

        $response->assertRedirect(route('loans.index'));
        $loan->refresh();
        $this->assertEquals('Returned', $loan->status);
        $this->assertEquals(Carbon::today()->format('Y-m-d'), $loan->return_date->format('Y-m-d'));

        // Check stock is restored back to 10
        $this->product->refresh();
        $this->assertEquals(10, $this->product->stock);
    }
}
