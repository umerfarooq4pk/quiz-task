<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $q1 = Question::create(['question' => 'What does PHP stand for?']);
        $q1->answers()->createMany([
            ['answer_text' => 'Personal Home Page', 'is_correct' => true],
            ['answer_text' => 'Private Hypertext Processor'],
            ['answer_text' => 'Public HTML Processor'],
            ['answer_text' => 'Programming Home Protocol'],
        ]);

        $q2 = Question::create(['question' => 'Which version introduced namespaces in PHP?']);
        $q2->answers()->createMany([
            ['answer_text' => 'PHP 5.3', 'is_correct' => true],
            ['answer_text' => 'PHP 7.0'],
            ['answer_text' => 'PHP 5.0'],
            ['answer_text' => 'PHP 8.0'],
        ]);

        $q3 = Question::create(['question' => 'Which function is used to include one PHP file into another?']);
        $q3->answers()->createMany([
            ['answer_text' => 'import'],
            ['answer_text' => 'include', 'is_correct' => true],
            ['answer_text' => 'insert'],
            ['answer_text' => 'require_once_all'],
        ]);

        $q4 = Question::create(['question' => 'Which superglobal is used to collect form data after submitting an HTML form with POST?']);
        $q4->answers()->createMany([
            ['answer_text' => '$_POST', 'is_correct' => true],
            ['answer_text' => '$_GET'],
            ['answer_text' => '$_REQUEST'],
            ['answer_text' => '$_FORM'],
        ]);

        $q5 = Question::create(['question' => 'Which keyword is used to inherit a class in PHP?']);
        $q5->answers()->createMany([
            ['answer_text' => 'extends', 'is_correct' => true],
            ['answer_text' => 'inherits'],
            ['answer_text' => 'super'],
            ['answer_text' => 'implements'],
        ]);

    }
}
