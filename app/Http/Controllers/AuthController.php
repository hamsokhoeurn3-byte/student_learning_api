<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

    public function loginApi(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = $this->findUserByLoginId($request->login_id);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|string|max:20',
            'nationality' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'year_level' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|string|max:50',
            'advisor' => 'nullable|string|max:255',
            'enrollment_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $validated['student_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'] ?? now()->toDateString(),
            'gender' => $validated['gender'],
            'nationality' => $validated['nationality'] ?? 'Cambodian',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'department' => $validated['department'] ?? null,
            'major' => $validated['major'] ?? null,
            'academic_year' => $validated['academic_year'] ?? null,
            'year_level' => $validated['year_level'] ?? null,
            'semester' => $validated['semester'] ?? null,
            'advisor' => $validated['advisor'] ?? null,
            'enrollment_date' => $validated['enrollment_date'] ?? now()->toDateString(),
            'status' => $validated['status'] ?? 'enrolled',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'user' => $user,
            'student' => $student,
            'token' => $token,
        ], 201);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'message' => 'Profile retrieved successfully.',
            'user' => $user,
            'profile' => $this->getProfileData($user),
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'student') {
            $forbiddenFields = array_values(array_diff(
                array_keys($request->all()),
                ['profile_picture', '_token', '_method']
            ));

            if ($forbiddenFields !== []) {
                $message = 'Students may only update their profile picture.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => $message,
                        'forbidden_fields' => $forbiddenFields,
                    ], 422);
                }

                return back()->withErrors(['profile' => $message]);
            }

            $validated = $request->validate([
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($request->hasFile('profile_picture')) {
                if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $user->profile_picture = Storage::disk('public')->putFile('profile-pictures', $request->file('profile_picture'));
                $user->save();
            }

            if (! $request->expectsJson()) {
                return back()->with('status', 'Profile picture updated successfully.');
            }

            $user = $user->fresh();

            return response()->json([
                'message' => 'Profile picture updated successfully.',
                'user' => $user,
                'profile' => $this->getProfileData($user),
            ], 200);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $rules['first_name'] = 'nullable|string|max:100';
        $rules['last_name'] = 'nullable|string|max:100';
        $rules['department'] = 'nullable|string|max:255';
        $rules['position'] = 'nullable|string|max:255';

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->profile_picture = Storage::disk('public')->putFile('profile-pictures', $request->file('profile_picture'));
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $profile = $this->getRoleProfile($user);

        if ($profile) {
            if (isset($validated['first_name'])) {
                $profile->first_name = $validated['first_name'];
            }

            if (isset($validated['last_name'])) {
                $profile->last_name = $validated['last_name'];
            }

            if (isset($validated['department'])) {
                $profile->department = $validated['department'];
            }

            if (isset($validated['position'])) {
                $profile->position = $validated['position'];
            }

            $profile->save();
        }

        if (! $request->expectsJson()) {
            return back()->with('status', 'Profile updated successfully.');
        }

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user->fresh(),
            'profile' => $this->getProfileData($user->fresh()),
        ], 200);
    }

    protected function findUserByLoginId(string $loginId): ?User
    {
        $student = Student::where('student_id', $loginId)->with('user')->first();

        if ($student && $student->user) {
            return $student->user;
        }

        $teacher = Teacher::where('teacher_id', $loginId)->with('user')->first();

        if ($teacher && $teacher->user) {
            return $teacher->user;
        }

        $admin = Admin::where('admin_id', $loginId)->with('user')->first();

        if ($admin && $admin->user) {
            return $admin->user;
        }

        return null;
    }

    protected function getRoleProfile(User $user)
    {
        if ($user->role === 'student') {
            return $user->student;
        }

        if ($user->role === 'teacher') {
            return $user->teacher;
        }

        if ($user->role === 'admin') {
            return $user->admin;
        }

        return null;
    }

    protected function getProfileData(User $user): array
    {
        $profile = $this->getRoleProfile($user);

        return [
            'role' => $user->role,
            'name' => $user->name,
            'email' => $user->email,
            'profile' => $profile ? $profile->toArray() : null,
        ];
    }
}


