<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $app_setting['app_name'] }} Admin</title>
    {{-- jquery cdn --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- AlpineJS --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-b from-blue-100 to-blue-300 font-sans antialiased min-h-screen">

    <div class="px-4 pt-6 pb-16 flex justify-center items-start">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-6xl transition-all duration-300">

            <!-- Header -->
            <header class="flex justify-between items-center border-b-4 border-blue-600 pb-4 mb-8">
                <!-- Logo + Title -->
                <div class="flex items-center gap-4">
                    <img src="{{ URL::asset($app_setting['app_logo']) ?? asset('images/logo-telemedicine.png') }}" alt="EEPIS Logo"
                        class="h-12 w-12 rounded-xl shadow-md">
                    <h1
                        class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-500 to-blue-600 tracking-tight drop-shadow-md">
                        Admin Dashboard {{ $app_setting['app_name'] }}
                    </h1>
                </div>
                <!-- Admin Info + Logout -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 bg-blue-100 px-4 py-2 rounded-xl shadow">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                        </svg>
                        <p class="text-blue-700 font-semibold">Hello, Admin</p>
                    </div>
                    <form action="{{ route('logout') }}" method="GET">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-800 text-white rounded-2xl shadow transition p-3 flex items-center justify-center"
                            title="Logout">
                            <!-- Heroicons logout icon -->
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Navigation -->
            <nav class="flex flex-col md:flex-row gap-4 md:gap-8 mb-8">
                <a href="{{ route('admin.dashboard.index') }}"
                    class="text-gray-700 px-5 py-2 rounded-xl shadow transition font-medium
                        {{ request()->routeIs('admin.dashboard.index') ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-100' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="text-gray-700 px-5 py-2 rounded-xl shadow transition font-medium
                        {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-100' }}">
                    Users
                </a>
                <a href="{{ route('admin.settings.index') }}"
                    class="text-gray-700 px-5 py-2 rounded-xl shadow transition font-medium
                        {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-100' }}">
                    Settings
                </a>
            </nav>

            <!-- Main Content -->
            <main class="mt-6">
                @yield('content')
            </main>

            <!-- Footer Info -->
            <footer class="mt-16 pt-8 border-t-4 border-blue-600">
                <p class="text-sm text-gray-600 text-center">
                    {{ $app_setting['app_name'] }} — Connecting care with technology.
                </p>
            </footer>
        </div>
    </div>

    @yield('scripts')
</body>

</html>
