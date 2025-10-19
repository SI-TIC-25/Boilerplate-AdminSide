<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['student', 'session.class.course'])
            ->latest()
            ->paginate(10);

        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $sessions = Session::with('class.course')->get();
        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))->get();

        return view('attendances.create', compact('sessions', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:sessions_class,id',
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:present,absent',
        ]);

        Attendance::create($validated);

        return redirect()->route('attendances.index')
                         ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function edit(Attendance $attendance)
    {
        $sessions = Session::with('class.course')->get();
        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))->get();

        return view('attendances.edit', compact('attendance', 'sessions', 'students'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:sessions_class,id',
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:present,absent',
        ]);

        $attendance->update($validated);

        return redirect()->route('attendances.index')
                         ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendances.index')
                         ->with('success', 'Data absensi berhasil dihapus.');
    }
}
