<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Sesi Kelas') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('sessions.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Kelas</label>
                    <select name="class_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} — {{ $class->course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Topik</label>
                    <input type="text" name="topic" value="{{ old('topic') }}"
                           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('topic') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Tanggal & Waktu</label>
                    <input type="datetime-local" name="session_date" value="{{ old('session_date') }}"
                           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('session_date') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Durasi (menit)</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', 90) }}"
                           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('duration_minutes') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('sessions.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
