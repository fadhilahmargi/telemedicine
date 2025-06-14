<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        const authID = "{{ auth()->id() }}";
    </script>

    @vite(['resources/js/app.js', 'resources/js/call.js'])
</head>

<body class="bg-blue-100 min-h-screen flex flex-col">
    @include('components.call-popup')
    {{-- video prep container here --}}
    @yield('video-preparation')
    {{--    video-container here --}}
    @include('components.video-container')

    <!-- Header -->
    <div class="bg-[#1E3A8A] h-[80px] fixed top-0 left-0 right-0 flex justify-between items-center px-8 shadow-md z-20">
        <!-- Logo Kiri -->
        <div class="flex items-center space-x-6">
            <img src="{{ asset('images/logo-pens.png') }}" alt="Logo PENS"
                class="h-14 border border-gray-300 p-2 rounded-lg shadow-sm bg-white">
            <img src="{{ URL::asset($app_setting['app_logo']) ?? asset('images/logo-telemedicine.png') }}"
                alt="Logo Telemedicine" class="h-14 border border-gray-300 p-2 rounded-lg shadow-sm bg-white">
            <!-- Judul Aplikasi -->
            <span class="text-3xl font-extrabold tracking-wide text-white drop-shadow-[2px_2px_3px_rgba(0,0,0,0.5)]">
                <span class="bg-gradient-to-br from-blue-100 via-white to-blue-400 text-transparent bg-clip-text">
                    {{ $app_setting['app_name'] }}
                </span>
            </span>
        </div>

        <!-- Histori + Logout -->
        <div class="flex items-center space-x-6 text-white">

            <!-- Tombol Histori -->
            {{-- filepath: resources/views/components/layouts/base.blade.php --}}
            @php
                $isHistory = request()->routeIs('history.index');
            @endphp

            @if (!$isHistory)
                <!-- Tombol History tampil jika BUKAN di halaman history -->
                <a href="{{ route('history.index') }}"
                    class="flex items-center space-x-2 hover:text-yellow-300 transition" title="Histori Catatan">
                    <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                    <span class="text-lg hidden md:inline">History</span>
                </a>
            @else
                <!-- Tombol Dashboard tampil jika sedang di halaman history -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 hover:text-green-300 transition"
                    title="Kembali ke Dashboard">
                    <i class="fa-solid fa-house text-xl"></i>
                    <span class="text-lg hidden md:inline">Dashboard</span>
                </a>
            @endif

            <!-- Tombol Logout -->
            <a href="{{ route('logout') }}" class="flex items-center space-x-2 hover:text-red-300 transition"
                title="Logout">
                <i class="fa-solid fa-right-from-bracket text-xl"></i>
                <span class="text-lg">Logout</span>
            </a>
        </div>

    </div>

    <!-- Main Content -->
    <div class="flex flex-1 flex-col overflow-auto pt-[110px] pb-[100px]" id="layout-content">
        @yield('content')
    </div>


    <!-- Footer -->
    @include('components.user-footer')
</body>

</html>
