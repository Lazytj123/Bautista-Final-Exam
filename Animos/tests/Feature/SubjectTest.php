<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_subjects()
    {
        $student = \App\Models\Student::factory()->create();
        \App\Models\Subject::factory()->count(3)->create(['student_id' => $student->id]);

        $response = $this->getJson("/api/students/{$student->id}/subjects");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'subject_code',
                    'name',
                    'description',
                    'instructor',
                    'schedule',
                    'grades',
                    'average_grade',
                    'remarks',
                    'date_taken'
                ]
            ]
        ]);
    }

    public function test_can_add_subject()
    {
        $student = \App\Models\Student::factory()->create();

        $subjectData = [
            'subject_code' => 'T3B-123',
            'name' => 'Application Lifecycle Management',
            'description' => 'Lorem ipsum dolor sit amet.',
            'instructor' => 'Mr. John Doe',
            'schedule' => 'MW 7AM-12PM',
            'grades' => [
                'prelims' => 2.75,
                'midterms' => 2.0,
                'pre_finals' => 1.75,
                'finals' => 1.0
            ],
            'average_grade' => 1.87,
            'remarks' => 'PASSED',
            'date_taken' => '2024-01-01',
        ];

        $response = $this->postJson("/api/students/{$student->id}/subjects", $subjectData);

        $response->assertStatus(201);
        $response->assertJsonFragment($subjectData);
    }
}
