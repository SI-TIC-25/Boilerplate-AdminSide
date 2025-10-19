<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimbel Cerdas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100">

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-24">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Selamat Datang di <span class="text-yellow-300">Bimbel Cerdas</span>
            </h1>
            <p class="text-lg md:text-xl mb-8">
                Platform bimbingan belajar digital untuk siswa yang ingin berprestasi!
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-yellow-400 text-gray-800 font-semibold rounded-lg hover:bg-yellow-300 transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 transition">Daftar Sekarang</a>
            </div>
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Mengapa Memilih Kami?</h2>
            <p class="max-w-3xl mx-auto text-gray-600 dark:text-gray-300 mb-12">
                Bimbel Cerdas menyediakan pengalaman belajar interaktif dengan tutor profesional, materi terkini,
                dan sistem evaluasi terstruktur. Kami hadir membantu siswa mencapai potensi terbaiknya.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow text-center">
                    <h3 class="text-xl font-semibold mb-2">Tutor Profesional</h3>
                    <p class="text-gray-600 dark:text-gray-300">Dipandu oleh pengajar berpengalaman yang ahli di bidangnya.</p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow text-center">
                    <h3 class="text-xl font-semibold mb-2">Materi Terupdate</h3>
                    <p class="text-gray-600 dark:text-gray-300">Sesuai kurikulum terbaru dan mudah dipahami siswa.</p>
                </div>

                <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow text-center">
                    <h3 class="text-xl font-semibold mb-2">Kelas Fleksibel</h3>
                    <p class="text-gray-600 dark:text-gray-300">Belajar kapan saja, di mana saja, sesuai jadwal kamu.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Program Kursus --}}
    <section class="bg-blue-50 dark:bg-gray-800 py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-10">Program Kursus Populer</h2>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach ([
                    ['Matematika', 'Asah logika dan kemampuan berhitung dengan latihan intensif.'],
                    ['Bahasa Inggris', 'Kuasai grammar, speaking, dan writing dengan tutor ahli.'],
                    ['Fisika', 'Pahami konsep sains dengan eksperimen dan pembahasan soal.'],
                ] as [$title, $desc])
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-2">{{ $title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $desc }}</p>
                        <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Gabung Sekarang →</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Tutor Section (dari database users role=Tutor) --}}
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-10">Tutor Kami</h2>

            @if ($tutors->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">Belum ada tutor terdaftar.</p>
            @else
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($tutors as $tutor)
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow text-center hover:shadow-lg transition">
                            <div class="w-24 h-24 mx-auto rounded-full bg-blue-200 dark:bg-gray-700 flex items-center justify-center text-2xl font-bold text-blue-700 mb-4">
                                {{ strtoupper(substr($tutor->name, 0, 1)) }}
                            </div>
                            <h3 class="text-lg font-semibold">{{ $tutor->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $tutor->subject ?? 'Tutor Profesional' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-blue-600 text-white py-16 text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Belajar Bersama Bimbel Cerdas?</h2>
        <p class="mb-8 text-lg">Mulai perjalanan belajar kamu dengan bimbingan terbaik dari tutor kami.</p>
        <a href="{{ route('register') }}" class="px-8 py-3 bg-yellow-400 text-gray-800 font-semibold rounded-lg hover:bg-yellow-300 transition">
            Daftar Sekarang
        </a>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-6 text-center">
        <p>&copy; {{ date('Y') }} Bimbel Cerdas. All rights reserved.</p>
    </footer>

</body>
</html>
