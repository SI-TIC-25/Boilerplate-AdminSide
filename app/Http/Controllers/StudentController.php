<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Tampilkan daftar siswa.
     */
    public function index()
    {
        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))
                        ->latest()
                        ->paginate(10);

        return view('students.index', compact('students'));
    }

    /**
     * Form tambah siswa.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Simpan siswa baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $studentRole = Role::where('name', 'Siswa')->firstOrFail();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $studentRole->id,
        ]);

        return redirect()->route('students.index')
                         ->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Form edit siswa.
     */
    public function edit(User $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update data siswa.
     */
    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $student->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $student->password,
        ]);

        return redirect()->route('students.index')
                         ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus siswa.
     */
    public function destroy(User $student)
    {
        $student->delete();

        return redirect()->route('students.index')
                         ->with('success', 'Siswa berhasil dihapus.');
    }
}
