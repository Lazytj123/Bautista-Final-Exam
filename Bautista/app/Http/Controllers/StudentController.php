<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('year')) {
            $query->where('year', $request->input('year'));
        }
        if ($request->has('course')) {
            $query->where('course', $request->input('course'));
        }
        if ($request->has('section')) {
            $query->where('section', $request->input('section'));
        }

        if ($request->has('sort')) {
            $query->orderBy($request->input('sort'), 'asc');
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('lastname', 'like', '%' . $request->input('search') . '%');
            });
        }

        if ($request->has('limit')) {
            $query->limit($request->input('limit'));
        }

        if ($request->has('offset')) {
            $query->offset($request->input('offset'));
        }

        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));
            $students = $query->get($fields);
        } else {
            $students = $query->get();
        }

        $metadata = [
            'count' => $students->count(),
            'search' => $request->input('search', null),
            'limit' => $request->input('limit', 0),
            'offset' => $request->input('offset', 0),
            'fields' => $request->input('fields', [])
        ];

        return response()->json([
            'metadata' => $metadata,
            'students' => $students
        ]);
    }

    public function store(Request $request)
    {
        $student = Student::create($request->all());
        return response()->json($student, 201);
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json($student);
    }
}
