<?php

namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassType::insert([
            ['name' => 'Yoga', 'description' => 'A mind and body practice that combines physical postures, breathing exercises, and meditation.','minutes' => 60],
            ['name' => 'HIIT', 'description' => 'High-Intensity Interval Training involves short bursts of intense exercise followed by rest or low-intensity periods.','minutes' => 45],
            ['name' => 'Strength Training', 'description' => 'A type of physical exercise specializing in the use of resistance to induce muscular contraction, building strength and endurance.','minutes' => 50],
            ['name' => 'Cardio Kickboxing', 'description' => 'A high-energy workout that combines martial arts techniques with fast-paced cardio.','minutes' => 30],
            ['name' => 'Aerobics', 'description' => 'A form of physical exercise that combines rhythmic aerobic exercise with stretching and strength training routines.','minutes' => 40],
            ['name' => 'Dance Fitness', 'description' => 'A fun and energetic workout that combines dance moves with cardiovascular exercise.','minutes' => 55],
            ['name' => 'Pilates', 'description' => 'A low-impact exercise that focuses on strengthening muscles while improving postural alignment and flexibility.','minutes' => 60],
            ['name' => 'Zumba', 'description' => 'A fitness program that combines Latin and international music with dance moves.','minutes' => 50],
            ['name' => 'Spinning', 'description' => 'A high-intensity indoor cycling workout that focuses on endurance, strength, intervals, and recovery.','minutes' => 45],
            ['name' => 'CrossFit', 'description' => 'A high-intensity fitness program incorporating elements from several sports and types of exercise.','minutes' => 60],
           
        ]);
    }
}
