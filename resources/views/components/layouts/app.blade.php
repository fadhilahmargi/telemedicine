<!-- filepath: resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'EEPIS Telehealth')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head')
</head>

<body class="bg-blue-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-900 shadow-lg">
        <div class="container mx-auto flex items-center justify-between py-3 px-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12 rounded bg-white p-1">
                <span class="text-2xl font-bold text-white tracking-wide">EEPIS Telehealth</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}"
                    class="text-white text-lg hover:text-blue-300 transition flex items-center gap-1">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="{{ route('logout') }}"
                    class="text-white text-lg hover:text-blue-300 transition flex items-center gap-1">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center py-8 px-2">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-800 py-3 px-6">
        <div class="flex items-center justify-between">
            <!-- Left: Profile -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/default-profile.png') }}" alt="Profile"
                    class="w-8 h-8 rounded-full border-2 border-white object-cover">
                <span class="text-white font-semibold">Penjaga</span>
            </div>
            <!-- Center: Date & Time -->
            <div>
                <span
                    class="bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold tracking-widest text-base shadow">
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, MMMM D, YYYY  HH:mm:ss A') }}
                </span>
            </div>
            <!-- Right: Settings -->
            <div>
                <a href="{{ route('profile.edit') }}" class="text-white text-2xl hover:text-blue-300 transition"
                    title="Edit Profile">
                    <i class="fa-solid fa-user-gear"></i>
                </a>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>
