<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function homepage()
{
    $user = Auth::user(); // Get the full authenticated user object

    // Fetch assigned subjects for the logged-in user (teacher)
    $assignedSubjects = $user->subjects ?? collect(); // Make sure it's a collection if null

    return view('homepage', [
        'user' => $user,
        'assignedSubjects' => $assignedSubjects, // Pass to the view
    ]);
}

}
