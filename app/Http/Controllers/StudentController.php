<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Performance;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;

class StudentController extends Controller
{
    /**
     * Store a new student in the database.
     */
    public function registerStudent()
    {
        // Fetch all classrooms
        $classrooms = Classroom::all();

        // Return the view with classrooms data
        return view('manageStudent.registerStudent', compact('classrooms'));
    }

    public function storeStudent(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'gender' => 'required|in:male,female',
            'ambition' => 'nullable|string|max:255',
            'presence' => 'nullable|integer|min:0',
            'absence' => 'nullable|integer|min:0',
            'behaviour' => 'nullable|integer|min:0',
        ]);

        // Create a new student
        Student::create([
            'name' => $request->name,
            'classroom_id' => $request->classroom_id,
            'gender' => $request->gender,
            'ambition' => $request->ambition,
            'presence' => $request->presence ?? 0,
            'absence' => $request->absence ?? 0,
            'behaviour' => $request->behaviour ?? 0,
        ]);

        return redirect()->route('registerStudent')->with('success', 'Student created successfully.');
    }

    public function viewListStudent($classroom_id)
    {
        $students = Student::where('classroom_id', $classroom_id)->get();
        $classroom = Classroom::findOrFail($classroom_id);
        $performances = Performance::all();
        $topic_names = Performance::select('topic_name')->distinct()->pluck('topic_name');
        $attendances = Attendance::all();
        $date = date(now());

        // dd($classroom);

        return view('manageStudent.listStudent', [
            'students' => $students,
            'classroom' => $classroom,
            'performances' => $performances,
            'topic_names' => $topic_names,
            'attendances' => $attendances,
            'date' => $date,
        ]);
    }

    public function storePerformance(Request $request)
    {
        // dd($request);
        $request->validate([
            'topicName' => 'required|string|max:255',
            'skill' => 'required|in:listening,speaking,reading,writing',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.performance_level' => 'required',
        ]);

        // dd($request);

        foreach ($request->students as $studentData) {
            // dd($request->skill, $studentData['performance_level']);

            Performance::updateOrCreate(
                [
                    'student_id' => $studentData['student_id'],
                    'topic_name' => $request->topicName, // Using topic name as unique identifier
                ],
                [
                    // dd($request->skill, $studentData['performance_level']),
                    $request->skill => (int)$studentData['performance_level'],
                ]
            );
        }

        return redirect()->back()->with('success', 'Performance data saved successfully!');
    }

    public function getPerformance(Request $request)
    {
        $skill = $request->query('skill');
        $topic_name = $request->query('topic_name');
        $classroomId = $request->query('classroom_id');

        // Fetch performance based on date & classroom
        $performances = Performance::where('topic_name', $topic_name)
            ->whereHas('student', function ($query) use ($classroomId) {
                $query->where('classroom_id', $classroomId);
            })
            ->get();
        $students = Student::where('classroom_id', $classroomId)->get();
        // dd($students);

        return view('manageStudent.partials.performance_table', compact('students', 'performances', 'skill'))->render();
    }

    public function storeAttendance(Request $request)
    {
        // dd($request);
        $request->validate([
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.attendance' => 'required|in:present,absent',
        ]);

        foreach ($request->students as $studentData) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentData['student_id'],
                    'date' => $request->date, // Unique based on student & date
                ],
                [
                    'is_present' => $studentData['attendance'] === 'present' ? true : false,
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance saved successfully!');
    }

    public function getAttendance(Request $request)
    {
        $date = $request->query('date');
        $classroomId = $request->query('classroom_id');

        // Fetch attendance based on date & classroom
        $attendances = Attendance::where('date', $date)
            ->whereHas('student', function ($query) use ($classroomId) {
                $query->where('classroom_id', $classroomId);
            })
            ->get();
        $students = Student::where('classroom_id', $classroomId)->get();
        // dd($students);

        return view('manageStudent.partials.attendance_table', compact('students', 'attendances', 'date'))->render();
    }

    public function updateBehaviour(Request $request, $id)
    {
        // dd($request->action);
        $request->validate([
            'action' => 'required|string|in:increase,decrease',
        ]);
    
        $student = Student::findOrFail($id);
    
        // Increase or Decrease the behaviour value
        if ($request->action === 'increase') {
            $student->behaviour += 1;
        } elseif ($request->action === 'decrease' && $student->behaviour > 0) {
            $student->behaviour -= 1;
        }
    
        $student->save();
    
        return response()->json([
            'success' => true,
            'new_behaviour' => $student->behaviour
        ]);
    }
    
}
