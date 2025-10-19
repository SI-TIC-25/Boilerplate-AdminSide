<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Kelas') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between mb-4">
                <a href="{{ route('classes.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Tambah Kelas</a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full text-left text-gray-800 dark:text-gray-100">
                <thead>
                    <tr class="border-b border-gray-300 dark:border-gray-700">
                        <th class="py-2 px-3">#</th>
                        <th class="py-2 px-3">Nama Kelas</th>
                        <th class="py-2 px-3">Kursus</th>
                        <th class="py-2 px-3">Tutor</th>
                        <th class="py-2 px-3">Mulai</th>
                        <th class="py-2 px-3">Berakhir</th>
                        <th class="py-2 px-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classes as $class)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-2 px-3">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3">{{ $class->name }}</td>
                            <td class="py-2 px-3">{{ $class->course->title ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $class->tutor->name ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $class->start_date ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $class->end_date ?? '-' }}</td>
                            <td class="py-2 px-3">
                                <a href="{{ route('classes.edit', $class) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('classes.destroy', $class) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus kelas ini?')" class="text-red-500 hover:underline ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-3">Belum ada kelas.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $classes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
