<?php

namespace Tests\Feature;

use App\Interfaces\LeaveRepositoryInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LeaveControllerTest extends TestCase
{
   use RefreshDatabase;

   protected $user;

   protected function setUp(): void
   {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->mock(LeaveRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('getUserLeaves')->andReturn([]);
            $mock->shouldReceive('hasWorkReportForDates')->andReturn(false);
            $mock->shouldReceive('applyLeave')->andReturn(true);
        });

   }
   #[Test]
    public function it_shows_the_leave_index_page()
    {
        $response = $this->actingAs($this->user)->get(route('leaves'));

        $response->assertStatus(200);
        $response->assertViewIs('leave');
        $response->assertViewHas('leaves');
        $response->assertViewHas('pageTitle', 'Leave Requests');
    }
    #[Test]
     public function it_stores_a_leave_successfully()
    {
        $payload = [
            'start_date' => now()->toDateString(),
            'end_date'   => now()->addDay()->toDateString(),
            'reason'     => 'Vacation',
        ];

        $response = $this->actingAs($this->user)->post(route('leaves.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Leave applied successfully!');
    }

    #[Test]
    public function it_fails_if_work_report_exists_for_dates()
    {
        // override mock behavior for this test
        $this->mock(LeaveRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('getUserLeaves')->andReturn([]);
            $mock->shouldReceive('hasWorkReportForDates')->andReturn(true);
            $mock->shouldReceive('applyLeave')->never();
        });

        $payload = [
            'start_date' => now()->toDateString(),
            'end_date'   => now()->addDay()->toDateString(),
            'reason'     => 'Vacation',
        ];

        $response = $this->actingAs($this->user)->post(route('leaves.store'), $payload);

        $response->assertSessionHasErrors(['leave']);
    }
}
