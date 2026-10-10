<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPeopleController extends Controller
{
    public function showStudent(Student $student): View
    {
        $student->load('user', 'department');

        return $this->showRecord('Student', $student, [
            'Student ID' => $student->student_id,
            'Name' => $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name),
            'Email' => $student->user?->email ?? 'Not set',
            'Department' => $student->department?->name ?? 'Not set',
            'Major' => $student->major,
            'Academic year' => $student->academic_year,
            'Year level' => $student->year_level,
            'Semester' => $student->semester,
            'Enrollment date' => $student->enrollment_date,
            'Status' => $student->status,
        ], route('admin.students'), route('admin.students.edit', $student), route('admin.students.destroy', $student));
    }

    public function editStudent(Student $student): View
    {
        $student->load('user', 'department');

        return $this->editRecord('Student', $student, route('admin.students.update', $student), route('admin.students'), [
            $this->field('Student ID', 'student_id', $student->student_id, true),
            $this->field('First name', 'first_name', $student->first_name, true),
            $this->field('Last name', 'last_name', $student->last_name, true),
            $this->field('Email', 'email', $student->user?->email, true, 'email'),
            $this->field('Date of birth', 'date_of_birth', $student->date_of_birth, true, 'date'),
            $this->field('Gender', 'gender', $student->gender, true, 'select', ['Male', 'Female']),
            $this->field('Department', 'department', $student->department?->name),
            $this->field('Major', 'major', $student->major),
            $this->field('Academic year', 'academic_year', $student->academic_year),
            $this->field('Year level', 'year_level', $student->year_level),
            $this->field('Semester', 'semester', $student->semester),
            $this->field('Enrollment date', 'enrollment_date', $student->enrollment_date, false, 'date'),
            $this->field('Advisor', 'advisor', $student->advisor),
            $this->field('Phone', 'phone', $student->phone),
            $this->field('Address', 'address', $student->address, false, 'textarea'),
            $this->field('Status', 'status', $student->status, true, 'select', ['enrolled', 'graduated', 'suspended', 'inactive']),
        ]);
    }

    public function updateStudent(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'string', 'max:50', Rule::unique('students', 'student_code')->ignore($student->id)],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->user_id)],
            'password' => 'nullable|string|min:8|confirmed',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'nationality' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'year_level' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:50',
            'advisor' => 'nullable|string|max:255',
            'enrollment_date' => 'nullable|date',
            'status' => 'required|in:enrolled,graduated,suspended,inactive',
        ]);

        DB::transaction(function () use ($student, $validated) {
            $student->update(collect($validated)->except(['email', 'password'])->all());

            if ($student->user) {
                $student->user->update([
                    'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
                    'email' => $validated['email'],
                    ...(!empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
                ]);
            }
        });

        return redirect()->route('admin.students.show', $student)->with('status', 'Student updated successfully.');
    }

    public function destroyStudent(Student $student): RedirectResponse
    {
        DB::transaction(function () use ($student) {
            if ($student->user) {
                $student->user->delete();
            } else {
                $student->delete();
            }
        });

        return redirect()->route('admin.students')->with('status', 'Student and linked account deleted.');
    }

    public function showTeacher(Teacher $teacher): View
    {
        $teacher->load('user', 'department');

        return $this->showRecord('Teacher', $teacher, [
            'Teacher ID' => $teacher->teacher_id,
            'Name' => $teacher->user?->name ?? trim($teacher->first_name . ' ' . $teacher->last_name),
            'Email' => $teacher->user?->email ?? 'Not set',
            'Department' => $teacher->department?->name ?? 'Not set',
            'Position' => $teacher->position,
            'Specialization' => $teacher->specialization,
            'Phone' => $teacher->phone,
            'Status' => $teacher->status,
        ], route('admin.teachers'), route('admin.teachers.edit', $teacher), route('admin.teachers.destroy', $teacher));
    }

    public function editTeacher(Teacher $teacher): View
    {
        $teacher->load('user', 'department');

        return $this->editRecord('Teacher', $teacher, route('admin.teachers.update', $teacher), route('admin.teachers'), [
            $this->field('Teacher ID', 'teacher_id', $teacher->teacher_id, true),
            $this->field('First name', 'first_name', $teacher->first_name, true),
            $this->field('Last name', 'last_name', $teacher->last_name, true),
            $this->field('Email', 'email', $teacher->user?->email, true, 'email'),
            $this->field('Department', 'department', $teacher->department?->name),
            $this->field('Position', 'position', $teacher->position),
            $this->field('Specialization', 'specialization', $teacher->specialization),
            $this->field('Date of birth', 'date_of_birth', $teacher->date_of_birth, false, 'date'),
            $this->field('Gender', 'gender', $teacher->gender, false, 'select', ['Male', 'Female']),
            $this->field('Phone', 'phone', $teacher->phone),
            $this->field('Status', 'status', $teacher->status, true, 'select', ['active', 'inactive']),
        ]);
    }

    public function updateTeacher(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            'teacher_id' => ['required', 'string', 'max:50', Rule::unique('teachers', 'teacher_code')->ignore($teacher->id)],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($teacher->user_id)],
            'password' => 'nullable|string|min:8|confirmed',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'phone' => 'nullable|string|max:30',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($teacher, $validated) {
            $teacher->update(collect($validated)->except(['email', 'password'])->all());

            if ($teacher->user) {
                $teacher->user->update([
                    'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
                    'email' => $validated['email'],
                    ...(!empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
                ]);
            }
        });

        return redirect()->route('admin.teachers.show', $teacher)->with('status', 'Teacher updated successfully.');
    }

    public function destroyTeacher(Teacher $teacher): RedirectResponse
    {
        DB::transaction(function () use ($teacher) {
            if ($teacher->user) {
                $teacher->user->delete();
            } else {
                $teacher->delete();
            }
        });

        return redirect()->route('admin.teachers')->with('status', 'Teacher and linked account deleted.');
    }

    private function field(string $label, string $name, mixed $value, bool $required = false, string $type = 'text', array $options = []): array
    {
        return compact('label', 'name', 'value', 'required', 'type', 'options');
    }

    private function showRecord(string $entity, mixed $record, array $details, string $backUrl, string $editUrl, string $deleteUrl): View
    {
        return view('pages.admin.people.show', compact('entity', 'record', 'details', 'backUrl', 'editUrl', 'deleteUrl'));
    }

    private function editRecord(string $entity, mixed $record, string $updateUrl, string $backUrl, array $fields): View
    {
        return view('pages.admin.people.edit', compact('entity', 'record', 'updateUrl', 'backUrl', 'fields'));
    }
}
