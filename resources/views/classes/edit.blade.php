<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kelas') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('classes.update', $class) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Nama Kelas</label>
                    <input type="text" name="name" value="{{ old('name', $class->name) }}" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Kursus</label>
                    <select name="course_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ $class->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Tutor</label>
                    <select name="tutor_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Tutor (opsional) --</option>
                        @foreach ($tutors as $tutor)
                            <option value="{{ $tutor->id }}" {{ $class->tutor_id == $tutor->id ? 'selected' : '' }}>
                                {{ $tutor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tutor_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Mulai</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $class->start_date) }}" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('start_date') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Berakhir</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $class->end_date) }}" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('end_date') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
