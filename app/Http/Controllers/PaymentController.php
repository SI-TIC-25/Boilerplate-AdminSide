<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['student', 'class.course'])
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))->get();
        $classes = ClassModel::with('course')->get();

        return view('payments.create', compact('students', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'class_id' => 'nullable|exists:classes,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'paid_at' => 'nullable|date',
        ]);

        $validated['paid_at'] = $validated['paid_at'] ?? now();

        Payment::create($validated);

        return redirect()->route('payments.index')
                         ->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit(Payment $payment)
    {
        $students = User::whereHas('role', fn($q) => $q->where('name', 'Siswa'))->get();
        $classes = ClassModel::with('course')->get();

        return view('payments.edit', compact('payment', 'students', 'classes'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'class_id' => 'nullable|exists:classes,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
            'paid_at' => 'nullable|date',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')
                         ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
                         ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
