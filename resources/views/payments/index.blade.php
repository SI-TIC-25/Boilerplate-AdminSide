<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between mb-4">
                <a href="{{ route('payments.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Tambah Pembayaran</a>
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
                        <th class="py-2 px-3">Jumlah</th>
                        <th class="py-2 px-3">Metode</th>
                        <th class="py-2 px-3">Status</th>
                        <th class="py-2 px-3">Tanggal Bayar</th>
                        <th class="py-2 px-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-2 px-3">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3">{{ $payment->student->name }}</td>
                            <td class="py-2 px-3">{{ $payment->class->name ?? '-' }}</td>
                            <td class="py-2 px-3">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="py-2 px-3">{{ $payment->method ?? '-' }}</td>
                            <td class="py-2 px-3">{{ ucfirst($payment->status) }}</td>
                            <td class="py-2 px-3">{{ $payment->paid_at }}</td>
                            <td class="py-2 px-3">
                                <a href="{{ route('payments.edit', $payment) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus pembayaran ini?')" class="text-red-500 hover:underline ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-3">Belum ada pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
