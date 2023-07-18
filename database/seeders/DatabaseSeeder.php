<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin', 
            'role' => 'admin', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Teacher1', 
            'role' => 'teacher', 
            'email' => 'teacher1@gmail.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Teacher2', 
            'role' => 'teacher', 
            'email' => 'teacher2@gmail.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Teacher3', 
            'role' => 'teacher', 
            'email' => 'teacher3@gmail.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Student', 
            'role' => 'student', 
            'email' => 'student@gmail.com',
            'password' => bcrypt('password'),
            'working_hours' => '40',
            'break_minutes' => '5',
        ]);
        User::factory()->count(3)->create();

        $courseNames = ['Html', 'CSS', 'Javascript', 'Php', 'Laravel'];
        foreach ($courseNames as $name) {
            Course::create([
                'name' => $name,
                'detail' => 'Test Mode',
            ]);
        }
        $courses = Course::all();
        
        User::where('role', 'teacher')->get()->each(function ($user) use ($courses) {
            $randomCourses = $courses->random(rand(1, $courses->count()));
            $user->courses()->attach($randomCourses);
        });
        
        User::where('role', 'student')->get()->each(function ($teacher) use ($courses) {
            $randomCourse = $courses->random();
            $teacher->courses()->attach($randomCourse);
        });
        
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            Quiz::create([
                'user_id' => 5,
                'quiz_date' => $faker->date(),
                'start_time' => $faker->time(),
                'finish_time' => $faker->time(),
                'break_allocation' => $faker->numberBetween(1, 4),
                'clock_in' => '2023-06-16 09:07:59',
                'clock_out' => '2023-06-16 18:07:59',
            ]);
        }
    }
}
