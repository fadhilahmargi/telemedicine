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

    <!-- Header -->
    <div class="bg-[#1E3A8A] h-[80px] fixed top-0 left-0 right-0 flex justify-between items-center px-8 shadow-md z-20">
        <!-- Logo Kiri -->
        <div class="flex items-center space-x-6">
            <img src="{{ asset('images/logo-pens.png') }}" alt="Logo PENS"
                class="h-14 border border-gray-300 p-2 rounded-lg shadow-sm bg-white">
            <img src="{{ asset('images/logo-telemedicine.png') }}" alt="Logo Telemedicine"
                class="h-14 border border-gray-300 p-2 rounded-lg shadow-sm bg-white">
            <!-- Judul Aplikasi -->
            <span class="text-3xl font-extrabold tracking-wide text-white drop-shadow-[2px_2px_3px_rgba(0,0,0,0.5)]">
                <span class="bg-gradient-to-br from-blue-100 via-white to-blue-400 text-transparent bg-clip-text">
                    EEPIS - Telehealth
                </span>
            </span>
        </div>

        <!-- Logout Button -->
        <a href="{{ route('logout') }}" class="flex items-center space-x-3 text-white hover:text-red-300 transition">
            <i class="fa-solid fa-right-from-bracket text-xl" title="Logout"></i>
            <span class="text-lg">Logout</span>
        </a>
    </div>


    <!-- Call Setup (Select Cameras) -->
    <div id="call-setup-container" class="hidden bg-gray-900 text-white p-4">
        <h2 class="text-lg font-semibold mb-2">Select Cameras for the Call</h2>
        <div id="camera-list" class="space-y-2"></div>
        <div class="mt-4 space-x-2">
            <button id="add-camera-btn" class="bg-green-500 text-white px-4 py-2 rounded" disabled>Add Camera</button>
            <button id="start-call-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Start Call</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-1 overflow-hidden pt-[80px]">
        @include('components.user-list')
        {{-- @yield('content') --}}
    </div>


    <!-- Footer -->
    @include('components.user-footer')
</body>

</html>
