{{-- resources/views/layouts/navbars/admin/sidebar.blade.php --}}

<nav x-data="{ sidebarOpen: window.innerWidth >= 1024 }" x-init="window.addEventListener('resize', () => sidebarOpen = window.innerWidth >= 1024)" class="fixed top-0 left-0 z-50 my-5 ms-4">

    <!-- Toggle button (mobile only) -->
    <div class="p-2 h-10 bg-pink-200 shadow rounded-2xl block lg:hidden">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-pink-100 focus:outline-none">
            <i class="fas fa-bars text-lg"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <div x-show="sidebarOpen" x-cloak @click.away="if (window.innerWidth < 1024) sidebarOpen = false"
        x-transition:enter="transition transform duration-300 ease-out" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition transform duration-300 ease-in"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-3 left-4 w-64 bg-white text-gray-700 shadow-lg z-50 p-4 rounded-2xl border border-gray-200 lg:block">

        <!-- Logo & close (mobile) -->
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold tracking-wide">
                SAFE<span class="text-pink-400">SHIELD</span>
            </a>
            <button @click="sidebarOpen = false" class="text-gray-500 hover:text-pink-300 focus:outline-none lg:hidden">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Menu -->
        <ul class="space-y-2">
            @foreach ($menus as $menu)
                @if (isset($menu['submenu']))
                    <li x-data="{ open: false }">
                        <a href="#" @click.prevent="open = !open"
                            class="flex justify-between items-center p-2 rounded hover:bg-pink-100">
                            <span><i class="{{ $menu['icon'] }} mr-2"></i>{{ $menu['title'] }}</span>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200"
                                :class="{ 'rotate-180': open }"></i>
                        </a>
                        <ul x-show="open" x-transition class="pl-4 space-y-2 mt-2">
                            @foreach ($menu['submenu'] as $submenu)
                                <li>
                                    <a href="{{ route($submenu['route']) }}"
                                        class="block p-2 rounded hover:bg-pink-100 {{ request()->routeIs($submenu['route']) ? 'bg-pink-200' : '' }}">
                                        <i class="{{ $submenu['icon'] }} mr-2"></i>{{ $submenu['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route($menu['route']) }}"
                            class="block p-2 rounded hover:bg-pink-100 {{ request()->routeIs($menu['route']) ? 'bg-pink-200' : '' }}">
                            <i class="{{ $menu['icon'] }} mr-2"></i>{{ $menu['title'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>
