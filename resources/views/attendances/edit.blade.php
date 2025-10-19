<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Absensi Siswa') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('attendances.update', $attendance) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Sesi Kelas</label>
                    <select name="session_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        @foreach ($sessions as $session)
                            <option value="{{ $session->id }}" {{ $attendance->session_id == $session->id ? 'selected' : '' }}>
                                {{ $session->class->name }} — {{ $session->class->course->title }} ({{ $session->session_date }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Siswa</label>
                    <select name="student_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ $attendance->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Hadir</option>
                        <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('attendances.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
