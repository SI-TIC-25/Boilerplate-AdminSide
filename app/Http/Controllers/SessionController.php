<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Classes;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::with('class.course')
            ->latest('session_date')
            ->paginate(10);

        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        $classes = ClassModel::with('course')->get();
        return view('sessions.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'topic' => 'required|string|max:255',
            'session_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:300',
        ]);

        Session::create($validated);

        return redirect()->route('sessions.index')
                         ->with('success', 'Sesi kelas berhasil ditambahkan.');
    }

    public function edit(Session $session)
    {
        $classes = ClassModel::with('course')->get();
        return view('sessions.edit', compact('session', 'classes'));
    }

    public function update(Request $request, Session $session)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'topic' => 'required|string|max:255',
            'session_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:300',
        ]);

        $session->update($validated);

        return redirect()->route('sessions.index')
                         ->with('success', 'Sesi kelas berhasil diperbarui.');
    }

    public function destroy(Session $session)
    {
        $session->delete();

        return redirect()->route('sessions.index')
                         ->with('success', 'Sesi kelas berhasil dihapus.');
    }
}
