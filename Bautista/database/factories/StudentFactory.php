<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = \App\Models\Subject::class;

    public function definition()
    {
        $grades = [
            'prelims' => $this->faker->randomFloat(2, 1, 5),
            'midterms' => $this->faker->randomFloat(2, 1, 5),
            'pre_finals' => $this->faker->randomFloat(2, 1, 5),
            'finals' => $this->faker->randomFloat(2, 1, 5),
        ];
        $average_grade = array_sum($grades) / count($grades);
        $remarks = $average_grade >= 3.0 ? 'PASSED' : 'FAILED';

        return [
            'subject_code' => $this->faker->regexify('[A-Z]{3}-[0-9]{3}'),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'instructor' => $this->faker->name,
            'schedule' => $this->faker->dayOfWeek . ' ' . $this->faker->time(),
            'grades' => $grades,
            'average_grade' => $average_grade,
            'remarks' => $remarks,
            'date_taken' => $this->faker->date('Y-m-d'),
        ];
    }
}
