<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pembayaran Siswa') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('payments.update', $payment) }}">
                @csrf
                @method('PUT')

                {{-- Siswa --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Siswa</label>
                    <select name="student_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ $payment->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Kelas</label>
                    <select name="class_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="">-- Tidak Ada --</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ $payment->class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} — {{ $class->course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jumlah Pembayaran --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Jumlah (Rp)</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}"
                           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('amount')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Metode Pembayaran --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Metode Pembayaran</label>
                    <input type="text" name="method" value="{{ old('method', $payment->method) }}"
                           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('method')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Pembayaran --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('status')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Pembayaran --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Tanggal Bayar</label>
                    <input type="date" name="paid_at"
                           value="{{ old('paid_at', $payment->paid_at ? $payment->paid_at : now()) }}"
                           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('paid_at')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end">
                    <a href="{{ route('payments.index') }}"
                       class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded mr-2">Batal</a>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
