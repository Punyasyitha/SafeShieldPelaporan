<nav x-data="{ sidebarOpen: false, masterOpen: false, transactionOpen: false }"
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 rounded-2xl my-5 fixed-start ms-5 relative z-50">
    <!-- Tombol untuk sidebar di mobile -->
    <div class="sm:hidden p-3 h-10 bg-pink-200 shadow z-10 rounded-2xl">
        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-pink-100 focus:outline-none">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Mobile -->
    <div x-show="sidebarOpen" @click.away="sidebarOpen = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-3 left-4 w-60 bg-gray-100 text-gray-700 shadow-lg z-50 p-3 space-y-4 transform -translate-x-full sm:hidden rounded-2xl border-0"
        :class="{ 'translate-x-0': sidebarOpen }">

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold">
                SAFE<span class="text-pink-300">SHIELD</span>
            </a>
            <button @click="sidebarOpen = false" class="text-gray-500 hover:text-pink-300 focus:outline-none">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <ul class="space-y-2">
            @foreach ($menus as $menu)
                @if (isset($menu['submenu']))
                    <li x-data="{ open: false }">
                        <a @click.prevent="open = !open" href="#"
                            class="block p-2 rounded hover:bg-pink-200 flex justify-between items-center">
                            <div>
                                <i class="{{ $menu['icon'] }} mr-2"></i>{{ $menu['title'] }}
                            </div>
                            <svg class="h-4 w-4 transform" :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <ul x-show="open" class="pl-4 space-y-2 mt-2">
                            @foreach ($menu['submenu'] as $submenu)
                                <li>
                                    <a href="{{ route($submenu['route']) }}"
                                        class="block p-2 rounded hover:bg-pink-200 {{ request()->routeIs($submenu['route']) ? 'bg-pink-200' : '' }}">
                                        <div>
                                            <i class="{{ $submenu['icon'] }} mr-2"></i>{{ $submenu['title'] }}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route($menu['route']) }}"
                            class="block p-2 rounded hover:bg-pink-200 {{ request()->routeIs($menu['route']) ? 'bg-pink-200' : '' }}">
                            <i class="{{ $menu['icon'] }} mr-2"></i>{{ $menu['title'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <!-- Sidebar Desktop -->
    <div class="hidden sm:block w-64 bg-gray-100 shadow-lg rounded-2xl min-h-screen p-5 space-y-6 overflow-y-auto">
        <div class="flex justify-center">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-gray-700">
                SAFE<span class="text-pink-300">SHIELD</span>
            </a>
        </div>
        <ul class="space-y-2">
            @foreach ($menus as $menu)
                @if (isset($menu['submenu']))
                    <li x-data="{ open: false }">
                        <a @click.prevent="open = !open" href="#"
                            class="block p-2 rounded hover:bg-pink-200 flex justify-between items-center">
                            <div>
                                <i class="{{ $menu['icon'] }} mr-2"></i>{{ $menu['title'] }}
                            </div>
                            <svg class="h-4 w-4 transform" :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <ul x-show="open" class="pl-4 space-y-2 mt-2">
                            @foreach ($menu['submenu'] as $submenu)
                                <li>
                                    <a href="{{ route($submenu['route']) }}"
                                        class="block p-2 rounded hover:bg-pink-200 {{ request()->routeIs($submenu['route']) ? 'bg-pink-200' : '' }}">
                                        <div>
                                            <i class="{{ $submenu['icon'] }} mr-2"></i>{{ $submenu['title'] }}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route($menu['route']) }}"
                            class="block p-2 rounded hover:bg-pink-200 {{ request()->routeIs($menu['route']) ? 'bg-pink-200' : '' }}">
                            <i class="{{ $menu['icon'] }} mr-2"></i>{{ $menu['title'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>
