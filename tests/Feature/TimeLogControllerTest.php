<?php

namespace Tests\Feature;

use App\Interfaces\LeaveRepositoryInterface;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TimeLogControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->mock(TaskRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('getByUser')
                ->andReturn([]);
            $mock->shouldReceive('getTotalMinutesByDate')
                ->andReturn(0);
            $mock->shouldReceive('create')
                ->andReturn(true);
        });

        $this->mock(LeaveRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('existsForDate')
                ->andReturn(false);
        });
    }

    #[Test]
    public function it_shows_the_time_log_index_page()
    {
        $response = $this->actingAs($this->user)->get(route('time'));

        $response->assertStatus(200);
        $response->assertViewIs('time');
        $response->assertViewHas('timeLogs');
    }

     #[Test]
    public function it_stores_a_task_successfully()
    {
        $payload = [
            'project'          => 'website-redesign',
            'work_date'        => now()->toDateString(),
            'time_spent'       => '02:30',
            'task_description' => 'Worked on homepage redesign',
        ];

        $response = $this->actingAs($this->user)->post(route('time.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Task added successfully!');
    }

    #[Test]
    public function it_fails_when_time_exceeds_ten_hours()
    {
        $payload = [
            'project'          => 'website-redesign',
            'work_date'        => now()->toDateString(),
            'time_spent'       => '11:00',
            'task_description' => 'Worked too long',
        ];

        $response = $this->actingAs($this->user)->post(route('time.store'), $payload);

        $response->assertSessionHasErrors(['time_spent']);
    }
}
