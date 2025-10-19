<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between mb-4">
                <a href="{{ route('enrollments.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Tambah Pendaftaran</a>
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
                        <th class="py-2 px-3">Siswa</th>
                        <th class="py-2 px-3">Kelas</th>
                        <th class="py-2 px-3">Kursus</th>
                        <th class="py-2 px-3">Status</th>
                        <th class="py-2 px-3">Tanggal Daftar</th>
                        <th class="py-2 px-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrollments as $enrollment)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-2 px-3">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3">{{ $enrollment->student->name }}</td>
                            <td class="py-2 px-3">{{ $enrollment->class->name }}</td>
                            <td class="py-2 px-3">{{ $enrollment->class->course->title ?? '-' }}</td>
                            <td class="py-2 px-3">{{ ucfirst($enrollment->status) }}</td>
                            <td class="py-2 px-3">{{ $enrollment->enrolled_at }}</td>
                            <td class="py-2 px-3">
                                <a href="{{ route('enrollments.edit', $enrollment) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus pendaftaran ini?')" class="text-red-500 hover:underline ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-3">Belum ada pendaftaran.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
