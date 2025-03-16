<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function edit(Request $request): View
    {
        $user = $request->user();
        $classrooms = Classroom::all(); // Fetch all available classrooms

        // Fetch assigned subjects for the logged-in user (teacher)
        $assignedSubjects = $user->subjects ?? collect(); // Directly from User model

        return view('manageProfile/editProfile', [
            'user' => $user,
            'classrooms' => $classrooms,
            'assignedSubjects' => $assignedSubjects, // Pass to the view
        ]);
    }



    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update user attributes
        $user->fill($request->validated());

        // If email is changed, reset verification status
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Explicitly update nullable fields
        $user->fullname = $request->input('fullname', $user->fullname);
        $user->age = $request->input('age', $user->age);
        $user->gender = $request->input('gender', $user->gender);
        $user->subject = $request->input('subject', $user->subject);
        $user->sub_subject = $request->input('sub_subject', $user->sub_subject);

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function teacheInfoInsert(Request $request)
    {
        $user = Auth::id();

        // Validate the input data
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);
        // dd($request->all());
        // Create a new student
        Subject::create([
            'name' => $request->subject_name,
            'user_id' => $user,
            'classroom_id' => $request->classroom_id,
        ]);

        return Redirect::route('profile.edit')->with('status', 'subject-updated');
    }

    public function teacheInfoDestroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('profile.edit')->with('status', 'Subject deleted successfully');
    }
}
