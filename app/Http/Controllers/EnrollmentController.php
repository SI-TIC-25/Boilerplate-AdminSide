<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Daftar pendaftaran siswa ke kelas.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['class.course', 'student'])
            ->latest()
            ->paginate(10);

        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Form tambah pendaftaran.
     */
    public function create()
    {
        $classes = ClassModel::with('course')->get();
        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))->get();

        return view('enrollments.create', compact('classes', 'students'));
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:users,id',
            'status' => 'required|string|max:50',
        ]);

        $validated['enrolled_at'] = now();

        Enrollment::create($validated);

        return redirect()->route('enrollments.index')
                         ->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    /**
     * Form edit pendaftaran.
     */
    public function edit(Enrollment $enrollment)
    {
        $classes = ClassModel::with('course')->get();
        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))->get();

        return view('enrollments.edit', compact('enrollment', 'classes', 'students'));
    }

    /**
     * Update data pendaftaran.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:users,id',
            'status' => 'required|string|max:50',
        ]);

        $enrollment->update($validated);

        return redirect()->route('enrollments.index')
                         ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    /**
     * Hapus pendaftaran.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')
                         ->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
