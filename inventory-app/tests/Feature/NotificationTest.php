<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'staff']);
    }

    /** @test */
    public function user_can_mark_all_notifications_as_read()
    {
        Notification::create([
            'user_id' => $this->user->id,
            'title' => 'Test Notification',
            'message' => 'Hello World',
            'is_read' => false
        ]);

        $response = $this->actingAs($this->user)->post(route('notifications.read'));
        $response->assertStatus(302); // Redirect back
        $this->assertDatabaseHas('notifications', [
            'user_id' => $this->user->id,
            'is_read' => true
        ]);
    }
}
