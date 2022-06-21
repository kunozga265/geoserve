<nav x-data="{ open: false }" class="bg-gray system-nav">
    <!-- Responsive Navigation Menu -->
    <aside  :class="{'extend': open}" class=" px-3 bg-gray-50 rounded dark:bg-gray-800 sidebar" aria-label="Sidebar">
        <div class="overflow-y-auto ">
            <div class="header">
                <div class="p-2 flex justify-end navigation-buttons">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            {{--                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />--}}
                            <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-center">
                    <div class="logo-variant">
                        <img src="{{asset('images/logo-variant.jpg')}}" alt="Geoserve Engineering Group Variant Logo">
                    </div>
                </div>
                <div class="text-center pt-2 py-4 text-white">
                    <div class="heading-font ">{{Auth::user()->firstName}} {{Auth::user()->middleName}} {{Auth::user()->lastName}}</div>
                    <div class="heading-font text-sm">{{Auth::user()->position->title}}</div>
                </div>
            </div>

            <ul class="space-y-4 px-10 p-6">
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 ">
                   <i class="text-lg mdi mdi-view-dashboard"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 ">
                   <i class="text-lg mdi mdi-book-alphabet"></i>
                        <span class="ml-3">Index</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                   <i class="text-lg mdi mdi-book-clock"></i>
                        <span class="ml-3">Pending</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                   <i class="text-lg mdi mdi-book-check"></i>
                        <span class="ml-3">Approved</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                   <i class="text-lg mdi mdi-finance"></i>
                        <span class="ml-3">Finance</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                   <i class="text-lg mdi mdi-home-group"></i>
                        <span class="ml-3">Projects</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                   <i class="text-lg mdi mdi-account-supervisor-circle"></i>
                        <span class="ml-3">Users</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                   <i class="text-lg mdi mdi-car-multiple"></i>
                        <span class="ml-3">Vehicles</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="mb-2 flex items-center p-2 text-sm font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                   <i class="text-lg mdi mdi-account"></i>
                        <span class="ml-3">Profile</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>
    <!-- Primary Navigation Menu -->
    <div class=" mx-auto px-4 sm:px-6 lg:px-8 shadow navbar">
        <div class="flex justify-between h-16">
            <div class="flex">
{{--                <div class="separator "></div>--}}
                <!-- Hamburger -->
                <div class="ml-3 flex items-center">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out">
                        <span class="material-icons">short_text</span>
                        {{--<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">

                            --}}{{--                            <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />--}}{{--
--}}{{--                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />--}}{{--
                        </svg>--}}
                    </button>
                </div>
                <!-- Logo -->
               {{-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>--}}

              {{--  <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>--}}
            </div>

            <!-- Settings Dropdown -->
            <div class="flex items-center">
                <div class="ml-3 relative hover:cursor-pointer cursor">
                    <div style="font-size:10px; font-weight: bold" class="absolute right-0 h-4 w-4 rounded-full text-white font-bold grid justify-center text-xs bg-red-500 flex items-center ">
                        12
                    </div>
                    <div class="h-9 w-9 rounded-full  grid justify-items-center flex items-center hover:cursor-pointer">
                        <img style="height:28px" src="{{asset('images/notifications.svg')}}" alt="Notifications Icon">
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="ml-3 h-10 w-10 flex justify-center items-center rounded-full bg-blue-700 cursor">
                            <i class="mdi mdi-account-circle text-white"></i>
                        </div>
                        {{--<button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>--}}
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>


        </div>
    </div>


    {{--<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden sidebar">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>--}}
</nav>
