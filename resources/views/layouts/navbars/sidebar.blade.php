<nav x-data="{ sidebarOpen: false }" class="relative z-50">
    <!-- Tombol untuk sidebar di mobile -->
    <div class="sm:hidden p-4 h-16 bg-purple-100 shadow z-10">
        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-white focus:outline-none">
            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Mobile -->
    <div x-show="sidebarOpen" @click.away="sidebarOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 w-64 bg-blue-600 text-white shadow-lg z-50 p-5 space-y-6 transform -translate-x-full sm:hidden"
        :class="{ 'translate-x-0': sidebarOpen }">

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold">
                MyWebsite<span class="text-yellow-300">Logo</span>
            </a>
            <button @click="sidebarOpen = false" class="text-white hover:text-yellow-300 focus:outline-none">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="block p-2 hover:bg-purple-500 rounded">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="block p-2 hover:bg-purple-500 rounded">
                    Data Pengaduan
                </a>
            </li>
            <li>
                <a href="#" class="block p-2 hover:bg-purple-500 rounded">
                    Status Pengaduan
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Desktop -->
    <div class="hidden sm:block w-64 bg-gradient-to-r from-purple-300 to-purple-200 shadow-lg min-h-screen p-5 space-y-6 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold">
            SAFE<span class="text-blue-700">SHIELD</span>
        </a>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="block p-2 hover:bg-purple-500 rounded">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="block p-2 hover:bg-purple-500 rounded">
                    Data Pengaduan
                </a>
            </li>
            <li>
                <a href="#" class="block p-2 hover:bg-purple-500 rounded">
                    Status Pengaduan
                </a>
            </li>
        </ul>
    </div>
</nav>
