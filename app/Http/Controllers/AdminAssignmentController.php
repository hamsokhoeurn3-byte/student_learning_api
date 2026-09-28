<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAssignmentController extends Controller
{
    public function show(Assignment $assignment): View
    {
        $assignment->load('course', 'creator');

        return view('pages.admin.assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment): View
    {
        return view('pages.admin.assignments.edit', [
            'assignment' => $assignment,
            'courses' => Course::orderBy('name')->get(['id', 'name', 'code']),
        ]);
    }

    public function update(Request $request, Assignment $assignment): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'due_date' => 'nullable|date',
            'status' => 'required|in:draft,published,closed',
        ]);

        $assignment->update($validated);

        return redirect()->route('admin.assignments.show', $assignment)->with('status', 'Assignment updated successfully.');
    }

    public function destroy(Assignment $assignment): RedirectResponse
    {
        $assignment->delete();

        return redirect()->route('admin.assignments')->with('status', 'Assignment deleted successfully.');
    }
}
