<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Tampilkan daftar kursus.
     */
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('courses.index', compact('courses'));
    }

    /**
     * Form tambah kursus.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Simpan kursus baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0'
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')
                         ->with('success', 'Kursus berhasil ditambahkan.');
    }

    /**
     * Form edit kursus.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update kursus.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0'
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
                         ->with('success', 'Kursus berhasil diperbarui.');
    }

    /**
     * Hapus kursus.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
                         ->with('success', 'Kursus berhasil dihapus.');
    }
}
