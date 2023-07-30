<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Course;
use App\Models\Quiz;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        
        // $faker = Faker::create();
        // for ($i = 0; $i < 10; $i++) {
        //     Quiz::create([
        //         'user_id' => 5,
        //         'quiz_date' => $faker->date(),
        //         'start_time' => $faker->time(),
        //         'finish_time' => $faker->time(),
        //         'total_marks' => $faker->numberBetween(1, 4),
        //         'clock_in' => '2023-06-16 09:07:59',
        //         'clock_out' => '2023-06-16 18:07:59',
        //     ]);
        // }
        
        $htmlQuestions = [
            [
                'course_id' => 1, // Assuming HTML course has course_id = 1
                'question' => 'What does HTML stand for?',
                'option_a' => 'Hyperlinks and Text Markup Language',
                'option_b' => 'Hyper Text Markup Language',
                'option_c' => 'Home Tool Markup Language',
                'option_d' => 'Hyper Text Makeup Language',
                'correct_option' => 'b',
                'total_marks' => 10,
            ],
            [
                'course_id' => 1,
                'question' => 'Which HTML tag is used to define an unordered list?',
                'option_a' => '<ul>',
                'option_b' => '<li>',
                'option_c' => '<ol>',
                'option_d' => '<list>',
                'correct_option' => 'a',
                'total_marks' => 10,
            ],
            [
                'course_id' => 1,
                'question' => 'What is the correct HTML element for inserting a line break?',
                'option_a' => '<break>',
                'option_b' => '<lb>',
                'option_c' => '<br>',
                'option_d' => '<newline>',
                'correct_option' => 'c',
                'total_marks' => 10,
            ],
            [
                'course_id' => 1,
                'question' => 'Which character entity represents the "at" symbol (@) in HTML?',
                'option_a' => '&copy;',
                'option_b' => '&at;',
                'option_c' => '&amp;',
                'option_d' => '&commat;',
                'correct_option' => 'd',
                'total_marks' => 10,
            ],
            [
                'course_id' => 1,
                'question' => 'What is the purpose of the HTML alt attribute?',
                'option_a' => 'It specifies the alignment of the image.',
                'option_b' => 'It provides a title for the image.',
                'option_c' => 'It specifies an alternative text for an image if it cannot be displayed.',
                'option_d' => 'It defines the size of the image.',
                'correct_option' => 'c',
                'total_marks' => 10,
            ],
        ];
        DB::table('quizzes')->insert($htmlQuestions);

        $cssQuestions = [
            [
                'course_id' => 2, // Assuming CSS course has course_id = 2
                'question' => 'Which CSS property is used to change the background color?',
                'option_a' => 'color',
                'option_b' => 'background-color',
                'option_c' => 'text-color',
                'option_d' => 'bgcolor',
                'correct_option' => 'b',
                'total_marks' => 10,
            ],
            [
                'course_id' => 2,
                'question' => 'Which CSS property is used to add shadows to elements?',
                'option_a' => 'text-shadow',
                'option_b' => 'box-shadow',
                'option_c' => 'shadow',
                'option_d' => 'element-shadow',
                'correct_option' => 'b',
                'total_marks' => 10,
            ],
            [
                'course_id' => 2,
                'question' => 'What does CSS stand for?',
                'option_a' => 'Colorful Style Sheets',
                'option_b' => 'Creative Style Sheets',
                'option_c' => 'Cascading Style Sheets',
                'option_d' => 'Computer Style Sheets',
                'correct_option' => 'c',
                'total_marks' => 10,
            ],
            [
                'course_id' => 2,
                'question' => 'Which CSS property is used to control the text size?',
                'option_a' => 'font-style',
                'option_b' => 'text-size',
                'option_c' => 'font-size',
                'option_d' => 'text-style',
                'correct_option' => 'c',
                'total_marks' => 10,
            ],
            [
                'course_id' => 2,
                'question' => 'In CSS, which property is used to control the space between elements?',
                'option_a' => 'margin',
                'option_b' => 'padding',
                'option_c' => 'border',
                'option_d' => 'spacing',
                'correct_option' => 'b',
                'total_marks' => 10,
            ],
        ];
        DB::table('quizzes')->insert($cssQuestions);

        $javascriptQuestions = [
            [
                'course_id' => 3, // Assuming JavaScript course has course_id = 3
                'question' => 'What is the correct way to declare a JavaScript variable?',
                'option_a' => 'v carName;',
                'option_b' => 'variable carName;',
                'option_c' => 'var carName;',
                'option_d' => 'variable = carName;',
                'correct_option' => 'c',
                'total_marks' => 10,
            ],
            [
                'course_id' => 3,
                'question' => 'Which built-in method returns the length of the string?',
                'option_a' => 'length()',
                'option_b' => 'size()',
                'option_c' => 'count()',
                'option_d' => 'length',
                'correct_option' => 'd',
                'total_marks' => 10,
            ],
            [
                'course_id' => 3,
                'question' => 'How do you write "Hello World" in an alert box?',
                'option_a' => 'msg("Hello World");',
                'option_b' => 'alertBox("Hello World");',
                'option_c' => 'alert("Hello World");',
                'option_d' => 'msgBox("Hello World");',
                'correct_option' => 'c',
                'total_marks' => 10,
            ],
            [
                'course_id' => 3,
                'question' => 'What is the output of the following JavaScript code?\n\nconsole.log(2 + "2");',
                'option_a' => '4',
                'option_b' => '22',
                'option_c' => 'undefined',
                'option_d' => 'NaN',
                'correct_option' => 'b',
                'total_marks' => 10,
            ],
            [
                'course_id' => 3,
                'question' => 'Which function is used to parse a string to an integer in JavaScript?',
                'option_a' => 'parseInt()',
                'option_b' => 'parseInteger()',
                'option_c' => 'stringToInt()',
                'option_d' => 'toInteger()',
                'correct_option' => 'a',
                'total_marks' => 10,
            ],
        ];
        DB::table('quizzes')->insert($javascriptQuestions);

        $users = User::all();
        $courses = Course::all();

        $faker = Faker::create();

        foreach ($users as $user) {
            foreach ($courses as $course) {
                DB::table('reports')->insert([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'quiz_date' => Carbon::now(),
                    'clock_in' => NULL,
                    'clock_out' => NULL,
                    'obtained_marks' => NULL,
                    'total_marks' => NULL,
                    'status' => NULL, // Set status based on obtained marks (true if passed, false if failed).
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

    }
}
