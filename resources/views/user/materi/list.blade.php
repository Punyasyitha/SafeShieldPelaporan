<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
        <div class="flex flex-col mb-4">
            <h6 class="text-lg font-bold mb-2 text-black">MATERI</h6>
            <hr class="horizontal dark mt-1 mb-2">

            <div class="flex flex-wrap justify-between items-center gap-2 mt-5">
                <input type="text" id="searchInput" placeholder="Search..."
                    class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-purple-100 w-full md:w-auto">
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mt-4" id="materiCardList">
            @foreach ($grouped as $modulid => $materis)
                @php
                    $modul = $materis->first();
                @endphp
                <div class="bg-purple-100 border border-purple-200 rounded-lg shadow-md p-4 hover:shadow-lg transition">
                    <div class="mb-3">
                        <h5 class="text-md font-bold text-gray-800">{{ $modul->nama_modul }}</h5>
                        <p class="text-sm text-gray-600 mt-1">{{ $modul->deskripsi ?? '-' }}</p>

                        <div class="mt-2">
                            <ul class="text-sm text-gray-900 space-y-1">
                                @foreach ($materis as $mtr)
                                    <li>
                                        <a href="{{ route('user.materi.show', encrypt($mtr->idmateri)) }}"
                                            class="flex items-center text-gray-600  cursor-pointer">
                                            <i class="fas fa-file mr-2"></i>
                                            {{ $mtr->judul_materi }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi untuk search
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let cards = document.querySelectorAll('#materiCardList > div');
            cards.forEach(card => {
                let text = card.innerText.toLowerCase();
                card.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Konfirmasi hapus
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });

        // Auto-hide alert
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = "opacity 0.5s ease-out";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    </script>
</x-app-layout>
