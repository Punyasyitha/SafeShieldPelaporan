{{-- resources/views/layouts/navbars/admin/topbar.blade.php --}}

<nav class="bg-transparent text-gray-100 px-6 py-4 flex justify-between items-center">

    <!-- Breadcrumb -->
    <div class="flex-1 min-w-0 ml-8 sm:ml-10 md:ml-20 lg:ml-40 xl:ml-[280px]">
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="flex space-x-2 text-sm text-white">
                <li class="truncate max-w-[150px]">
                    <a href="javascript:;" class="hover:underline">{{ $title }}</a>
                </li>
            </ol>
        </nav>
        <h6 class="text-white text-md truncate max-w-[200px]">{{ $title }}</h6>
    </div>

    <!-- User Dropdown -->
    <div class="relative">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="flex items-center bg-purple-200 text-black font-semibold py-2 px-4 rounded-lg shadow hover:shadow-lg transition-all duration-200 space-x-2">
                    <i class="fa-solid fa-user text-lg"></i>
                    <span class="truncate max-w-[100px]">
                        {{ Auth::user()->name }}
                    </span>
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    <i class="fa-solid fa-user mr-2 text-sm"></i> {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa-solid fa-right-from-bracket mr-2 text-sm"></i> {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

</nav>
