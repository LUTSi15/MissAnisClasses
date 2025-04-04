<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Performance;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Store a new student in the database.
     */
    public function registerStudent()
    {
        $userId = Auth::id();
        $user_classes = Subject::where('user_id', $userId)->get(); // Get multiple subjects

        if ($user_classes->isEmpty()) {
            return back()->with('error', 'No subjects found for this user.');
        }

        $classroomIds = $user_classes->pluck('classroom_id'); // Extract classroom IDs
        $classrooms = Classroom::whereIn('id', $classroomIds)->get(); // Fetch related classrooms

        return view('manageStudent.registerStudent', compact('classrooms'));
    }


    public function storeStudent(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'ic' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'gender' => 'required|in:male,female',
            'ambition' => 'nullable|string|max:255',
            'presence' => 'nullable|integer|min:0',
            'absence' => 'nullable|integer|min:0',
            'behaviour' => 'nullable|integer|min:0',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photo_path = null;

        // Upload and set visibility to public for the image
        $photo_path = $request->file('photo')->store('students', 's3');
        // dd($photo_path);
        Storage::disk('s3')->setVisibility($photo_path, 'public'); // Set the visibility to public

        // Create a new student
        Student::create([
            'name' => $request->name,
            'classroom_id' => $request->classroom_id,
            'ic' => $request->ic,
            'gender' => $request->gender,
            'ambition' => $request->ambition,
            'presence' => $request->presence ?? 0,
            'absence' => $request->absence ?? 0,
            'behaviour' => $request->behaviour ?? 0,
            'photo' => $photo_path,
        ]);

        return redirect()->route('registerStudent')->with('success', 'Student created successfully.');
    }

    /**
     * edit the student in the database.
     */
    public function editStudent($id)
    {
        $userId = Auth::id();
        $user_classes = Subject::where('user_id', $userId)->get(); // Get multiple subjects

        if ($user_classes->isEmpty()) {
            return back()->with('error', 'No subjects found for this user.');
        }

        $classroomIds = $user_classes->pluck('classroom_id'); // Extract classroom IDs
        $classrooms = Classroom::whereIn('id', $classroomIds)->get(); // Fetch related classrooms
        $student = Student::find($id);

        return view('manageStudent.editStudent', compact('classrooms', 'student'));
    }

    public function updateStudent(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'ic' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'gender' => 'required|in:male,female',
            'ambition' => 'nullable|string|max:255',
            'presence' => 'nullable|integer|min:0',
            'absence' => 'nullable|integer|min:0',
            'behaviour' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the student
        $student = Student::findOrFail($id);

        // Handle photo upload if a new one is provided
        if ($request->hasFile('photo')) {
            $photo_path = $request->file('photo')->store('students', 's3');
            Storage::disk('s3')->setVisibility($photo_path, 'public'); // Set visibility to public

            // Delete old photo if exists
            if ($student->photo) {
                Storage::disk('s3')->delete($student->photo);
            }

            $student->photo = $photo_path;
        }

        // Update student data
        $student->update([
            'name' => $request->name,
            'classroom_id' => $request->classroom_id,
            'ic' => $request->ic,
            'gender' => $request->gender,
            'ambition' => $request->ambition,
            'presence' => $request->presence ?? $student->presence,
            'absence' => $request->absence ?? $student->absence,
            'behaviour' => $request->behaviour ?? $student->behaviour,
        ]);

        return redirect()->route('viewStudent', $id)->with('success', 'Student updated successfully.');
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

    public function viewStudent($id)
    {
        $student = Student::with('performances', 'attendance', 'classroom')->find($id);
        // dd($student);
        return view('manageStudent.viewStudent',  compact('student'));
    }

    public function searchStudent(Request $request)
    {
        $student = Student::with('performances', 'attendance', 'classroom')->where('ic', $request->ic_number)->first();
        // dd($student);
        return view('manageStudent.viewChildren',  compact('student'));
    }
}
