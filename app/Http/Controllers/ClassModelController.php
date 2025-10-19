<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class ClassModelController extends Controller
{
    /**
     * Tampilkan daftar kelas.
     */
    public function index()
    {
        // eager load course & tutor (user)
        $classes = ClassModel::with(['course', 'tutor'])->latest()->paginate(10);
        return view('classes.index', compact('classes'));
    }

    /**
     * Form tambah kelas.
     */
    public function create()
    {
        $courses = Course::all();

        // Ambil user yang role = tutor
        $tutors = User::whereHas('role', function ($q) {
            $q->where('name', 'tutor');
        })->get();

        return view('classes.create', compact('courses', 'tutors'));
    }

    /**
     * Simpan kelas baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'course_id' => 'required|exists:courses,id',
            'tutor_id' => 'nullable|exists:users,id', // boleh null jika belum ada tutor
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);

        ClassModel::create($validated);

        return redirect()->route('classes.index')
                         ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Form edit kelas.
     */
    public function edit(ClassModel $class)
    {
        $courses = Course::all();

        $tutors = User::whereHas('role', function ($q) {
            $q->where('name', 'tutor');
        })->get();

        return view('classes.edit', compact('class', 'courses', 'tutors'));
    }

    /**
     * Update kelas.
     */
    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'course_id' => 'required|exists:courses,id',
            'tutor_id' => 'nullable|exists:users,id',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
                         ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Hapus kelas.
     */
    public function destroy(ClassModel $class)
    {
        $class->delete();

        return redirect()->route('classes.index')
                         ->with('success', 'Kelas berhasil dihapus.');
    }
}
