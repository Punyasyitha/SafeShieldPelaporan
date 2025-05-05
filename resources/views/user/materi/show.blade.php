<x-app-layout>
    {{-- Judul Materi Utama di paling atas --}}
    <div class="bg-white px-6 py-4 shadow-md rounded-md mb-4 mt-6">
        <div class="flex items-center justify-between">
            <!-- Tombol Kembali -->
            <button type="button" onclick="window.location='{{ route('user.materi.list') }}'"
                class="flex items-center bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                <i class="fas fa-circle-left me-1"></i>
            </button>

            <!-- Judul Materi -->
            <h2 class="text-xl font-bold text-gray-800 tracking-wide text-center flex-1">
                {{ strtoupper($submateriUtama->judul_materi) }}
            </h2>

            <!-- Spacer untuk menyimbangkan flex -->
            <div class="w-12"></div>
        </div>
    </div>

    <div x-data="{ open: false }" class="flex w-full">
        @if ($submateris->count() > 1)
            {{-- Sidebar --}}
            <div class="w-12 md:w-1/5 bg-gray-200 p-4 shadow-md rounded-l-lg relative">
                {{-- Judul Materi Utama (hanya tampil di desktop) --}}
                <h2 class="text-base md:text-lg font-bold text-gray-800 mb-4 break-words hidden md:block">
                    {{ strtoupper($submateriUtama->judul_materi) }}
                </h2>

                {{-- Hamburger Menu --}}
                <button @click="open = !open"
                    class="md:hidden mb-4 focus:outline-none flex justify-center items-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Sidebar Content (desktop) --}}
                <ul class="hidden md:block space-y-6 mt-8 border-l-2 border-gray-300 pl-2">
                    @foreach ($submateris as $submateri)
                        <li>
                            <a href="{{ route('user.materi.show', encrypt($submateri->idsubmateri)) }}"
                                class="flex items-start gap-2 text-sm {{ $submateri->idsubmateri == $submateriUtama->idsubmateri ? 'text-purple-500 font-bold' : 'text-gray-800' }}">
                                <div
                                    class="mt-1 w-3 h-3 rounded-full border-2
                                    {{ $submateri->idsubmateri == $submateriUtama->idsubmateri ? 'bg-purple-400 border-purple-400' : 'bg-gray-300 border-gray-400' }}">
                                </div>
                                <span class="break-words">{{ Str::limit($submateri->judul_submateri, 30) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- Dropdown Submateri (mobile) --}}
                <div x-show="open" class="absolute top-12 left-0 w-60 bg-white border shadow-lg z-50 md:hidden p-3">
                    <h2 class="text-base font-bold text-gray-800 mb-2 break-words md:hidden">
                        {{ strtoupper($submateriUtama->judul_materi) }}
                    </h2>
                    <ul class="space-y-2 border-l-2 border-gray-300 pl-2">
                        @foreach ($submateris as $submateri)
                            <li>
                                <a href="{{ route('user.materi.show', encrypt($submateri->idsubmateri)) }}"
                                    class="flex items-center gap-2 {{ $submateri->idsubmateri == $submateriUtama->idsubmateri ? 'text-gray-600 font-semibold' : 'text-gray-600' }}">
                                    <div
                                        class="w-3 h-3 rounded-full border-2
                                        {{ $submateri->idsubmateri == $submateriUtama->idsubmateri ? 'bg-purple-400 border-purple-400' : 'bg-gray-300 border-gray-400' }}">
                                    </div>
                                    {{ $submateri->judul_submateri }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Konten --}}
        <div
            class="w-full {{ $submateris->count() > 1 ? 'md:flex-1 rounded-r-lg' : 'rounded-lg' }} bg-white p-6 shadow-md">
            {{-- Judul Submateri --}}
            <h3 class="text-2xl font-semibold text-gray-700 mb-6">
                {{ $submateriUtama->judul_submateri }}
            </h3>

            {{-- Isi Materi --}}
            <div class="text-gray-800 leading-relaxed">
                {!! nl2br(e($submateriUtama->isi)) !!}
            </div>

            {{-- Navigasi Pagination --}}
            @if ($submateris->count() > 1)
                @php
                    $currentIndex = $submateris->search(
                        fn($item) => $item->idsubmateri == $submateriUtama->idsubmateri,
                    );
                    $prev = $submateris[$currentIndex - 1] ?? null;
                    $next = $submateris[$currentIndex + 1] ?? null;
                @endphp

                <div class="flex justify-end items-center gap-4 mt-8">
                    @if ($prev)
                        <a href="{{ route('user.materi.show', encrypt($prev->idsubmateri)) }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-full p-3 transition">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @else
                        <span class="bg-gray-200 text-gray-400 rounded-full p-3 cursor-not-allowed">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                    @endif

                    @if ($next)
                        <a href="{{ route('user.materi.show', encrypt($next->idsubmateri)) }}"
                            class="bg-purple-500 hover:bg-purple-600 text-white rounded-full p-3 transition">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <span class="bg-gray-200 text-gray-400 rounded-full p-3 cursor-not-allowed">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
