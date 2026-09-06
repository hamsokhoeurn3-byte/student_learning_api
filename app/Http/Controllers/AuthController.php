<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login Page
    |--------------------------------------------------------------------------
    */

    public function showLoginForm()
    {
        return view('pages.auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginId = $request->login_id;

        $user = null;

        /*
        |--------------------------------------------------------------------------
        | Find Student
        |--------------------------------------------------------------------------
        */

        $student = Student::where('student_id', $loginId)
            ->with('user')
            ->first();

        if ($student) {

            $user = $student->user;

        } else {

            /*
            |--------------------------------------------------------------------------
            | Find Teacher
            |--------------------------------------------------------------------------
            */

            $teacher = Teacher::where('teacher_id', $loginId)
                ->with('user')
                ->first();

            if ($teacher) {

                $user = $teacher->user;

            } else {

                /*
                |--------------------------------------------------------------------------
                | Find Admin
                |--------------------------------------------------------------------------
                */

                $admin = Admin::where('admin_id', $loginId)
                    ->with('user')
                    ->first();

                if ($admin) {
                    $user = $admin->user;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | User Not Found
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return back()
                ->withInput($request->only('login_id'))
                ->withErrors([
                    'login_id' => 'Invalid Student / Teacher / Admin ID.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Check Password
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->password, $user->password)) {

            return back()
                ->withInput($request->only('login_id'))
                ->withErrors([
                    'login_id' => 'Invalid ID or password.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Login
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Redirect According To Role
        |--------------------------------------------------------------------------
        */

        switch ($user->role) {

            case 'student':
                return redirect()->route('student.dashboard');

            case 'teacher':
                return redirect()->route('teacher.dashboard');

            case 'admin':
                return redirect()->route('admin.dashboard');

            default:

                Auth::logout();

                return back()->withErrors([
                    'login_id' => 'Invalid user role.',
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}