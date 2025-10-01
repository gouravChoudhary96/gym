<?php

namespace Tests\Feature;

use App\Models\ClassType;
use App\Models\ScheduledClass;
use App\Models\User;
use Database\Seeders\ClassTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstructorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_instructor_is_reddirect_to_instructor_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertRedirectToRoute('instructor.dashboard');
        $this->followRedirects($response)->assertSeeText("Hey Instructor");
    }

    public function test_instructor_can_schedule_a_class()
    {

        //Given
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        $this->seed(ClassTypeSeeder::class);
        // When
        $response = $this->actingAs($user)
            ->post('instructor/schedule', [
                'class_type_id' => ClassType::first()->id,
                'date' => '2025-12-01',
                'time' => '09:00:00'
            ]);
        // Then

        $this->assertDatabaseHas(
            'scheduled_classes',
            [
                'class_type_id' => ClassType::first()->id,
                'date_time' => '2025-12-01 09:00:00'
            ]

        );
        $response->assertRedirectToRoute('schedule.index');
    }

    public function test_instructor_can_cancel_class()
    {

        //Given
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        $this->seed(ClassTypeSeeder::class);
        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => '2025-10-03 01:45:00'
        ]);

        //When
        $response = $this->actingAs($user)
            ->delete('/instructor/schedule/' . $scheduledClass->id);

        //Then

        $this->assertDatabaseMissing('scheduled_classes', [
            'id' => $scheduledClass->id
        ]);
    }
    public function test_cannot_cancel_class_less_then_two_hours_before()
    {

        //Given
        $user = User::factory()->create([
            'role' => 'instructor'
        ]);

        $this->seed(ClassTypeSeeder::class);
        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => now()->addHours(1)->minutes(0)->seconds(0)
        ]);

        //When

        $response = $this->actingAs($user)
                    ->get('instructor/schedule');

         $response->assertDontSeeText('Cancel');           

        $response = $this->actingAs($user)
            ->delete('/instructor/schedule/' . $scheduledClass->id);

        //Then

        $this->assertDatabaseHas('scheduled_classes', [
            'id' => $scheduledClass->id
        ]);
    }
}
