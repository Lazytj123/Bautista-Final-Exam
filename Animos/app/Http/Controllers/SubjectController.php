<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index($studentId)
    {
        $subjects = Student::findOrFail($studentId)->subjects()->paginate();
        return response()->json($subjects);
    }

    public function store(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        $subject = $student->subjects()->create($this->validateData($request));
        return response()->json($subject, 201);
    }

    public function show($studentId, $subjectId)
    {
        $subject = Student::findOrFail($studentId)->subjects()->findOrFail($subjectId);
        return response()->json($subject);
    }

    public function update(Request $request, $studentId, $subjectId)
    {
        $subject = Student::findOrFail($studentId)->subjects()->findOrFail($subjectId);
        $subject->update($this->validateData($request));
        return response()->json($subject);
    }

    private function validateData($request)
    {
        return $request->validate([
            'subject_code' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'instructor' => 'required|string',
            'schedule' => 'required|string',
            'grades' => 'required|array',
            'grades.prelims' => 'required|numeric',
            'grades.midterms' => 'required|numeric',
            'grades.pre_finals' => 'required|numeric',
            'grades.finals' => 'required|numeric',
            'average_grade' => 'required|numeric',
            'remarks' => 'required|string',
            'date_taken' => 'required|date',
        ]);
    }
}
