<x-app-layout>
    <!-- Header -->
    <div class="mb-6">
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-800">SAFE<span class="text-purple-400">SHIELD</span>
                <p class="text-sm text-gray-600">Selamat datang di halaman dashboard SHAFESHIELD!</p>
        </div>
    </div>

    <div class="grid gap-6 mt-6 pb-2">
        @foreach ($list as $art)
            <div
                class="bg-white rounded-xl shadow-sm p-6 hover:shadow-xl transition duration-300 border border-gray-100 mb-3">
                <div class="flex flex-col md:flex-row gap-6 ">
                    @if ($art->gambar)
                        <a class="block md:w-52 flex-shrink-0">
                            <img src="{{ Storage::url($art->gambar) }}" alt="Gambar Artikel"
                                class="w-full h-32 md:h-36 object-cover rounded-lg transition duration-300 hover:scale-105">
                        </a>
                    @endif

                    <div class="flex flex-col justify-between flex-1">
                        <div>
                            <h2
                                class="text-2xl font-semibold text-gray-800 hover:text-purple-500 transition-colors duration-200">
                                <a href="{{ route('user.artikel.show', encrypt($art->idartikel)) }}">
                                    {{ $art->judul_artikel }}
                                </a>
                            </h2>
                            <p class="text-sm text-gray-500 mt-1 mb-3">
                                Oleh <span
                                    class="font-medium">{{ $art->nama_penulis ?? 'Penulis Tidak Diketahui' }}</span> ·
                                {{ \Carbon\Carbon::parse($art->tanggal_rilis)->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-gray-700 text-sm leading-relaxed">
                                {{ Str::limit(strip_tags($art->isi_artikel), 150, '...') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap justify-between items-center mt-4 gap-3">
                            <div class="flex gap-2">
                                <a href="{{ route('user.artikel.show', encrypt($art->idartikel)) }}"
                                    class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
