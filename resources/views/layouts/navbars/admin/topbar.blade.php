<nav class="bg-transparent text-gray-100 p-4 flex justify-between items-center">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-5 me-sm-6 me-5">
            @if ($title_group && $title_group != '-')
                <li class="breadcrumb-item text-sm"><a class="text-white" href="javascript:;">{{ $title_group }}</a>
                </li>
            @endif
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title_menu }}</li>
        </ol>
        <h6 class="font-weight-bolder px-5 text-white mb-0">{{ $title_group }} {{ $title_menu }}</h6>
    </nav>
    <div>
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="flex items-center space-x-2 bg-pink-200 text-black font-semibold py-2 px-4 rounded-lg shadow transition transform hover:shadow-lg hover:-translate-y-1">
                    <i class="fa fa-user-circle text-2xl"></i>
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
