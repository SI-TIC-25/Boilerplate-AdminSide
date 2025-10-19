<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Siswa') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('students.update', $student) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Password (Opsional)</label>
                    <input type="password" name="password" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" placeholder="Kosongkan jika tidak diganti">
                    @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
