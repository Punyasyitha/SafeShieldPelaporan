<x-app-layout>
    <div class="w-full mx-auto px-4 py-8 bg-white rounded-xl  mt-6">
        {{-- Judul --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-3">
            {{ $art->JUDUL_ARTIKEL }}
        </h1>

        {{-- Gambar Artikel --}}
        @if ($art->GAMBAR)
            <div class="mb-6">
                <img src="{{ asset('storage/' . $art->GAMBAR) }}" alt="Gambar Artikel"
                    class="w-full h-64 object-cover rounded-lg shadow-sm">
            </div>
        @endif

        {{-- Info Penulis dan Tanggal --}}
        <div class="text-sm text-gray-500 mb-6">
            Ditulis oleh <span
                class="font-semibold text-gray-700">{{ $art->NAMA_PENULIS ?? 'Tidak Diketahui' }}</span>
            pada {{ \Carbon\Carbon::parse($art->TANGGAL_RILIS)->translatedFormat('d F Y') }}
        </div>

        {{-- Isi Artikel --}}
        <div class="prose max-w-none text-gray-800 leading-relaxed">
            {!! nl2br(e($art->ISI_ARTIKEL)) !!}
        </div>

        {{-- Status Artikel (opsional, bisa disembunyikan dari user) --}}
        @if (auth()->user() && auth()->user()->role == 'admin')
            <div class="mt-6">
                <span
                    class="inline-block px-3 py-1 text-sm rounded-full text-white
                    {{ $art->STATUS == 'draft' ? 'bg-red-500' : ($art->STATUS == 'published' ? 'bg-green-500' : 'bg-yellow-500') }}">
                    Status: {{ ucfirst($art->STATUS) }}
                </span>
            </div>
        @endif

        {{-- Tombol Kembali --}}
        <div class="mt-8">
            <a href="{{ route('user.dashboard') }}"
                class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-2 px-4 rounded-lg transition">
                ← Kembali
            </a>
        </div>
    </div>
</x-app-layout>
