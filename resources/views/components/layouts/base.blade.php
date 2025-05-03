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
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- pemanggilan utk file didalam resources --}}

    <script>
        const authID = "{{ auth()->id() }}";
    </script>

</head>

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/call.js')
    <!--call popup-->
    @include('components.call-popup')
    <div class="min-h-screen w-full bg-[#00FFB3] flex items-center justify-center">
        <div
            class="lg:w-[1200px] lg:h-[800px] 2xl:w-[1200px] 2xl:h-[800px] xl:w-[1200px] xl:h-[800px] bg-[#000000] flex justify-between shadow-lg rounded overflow-hidden flex-col overflow-y-auto">
            <div class="bg-[#404749] h-[40px] flex justify-between items-center">
                <span class="text-white text-[14px] mx-4">Telemedicine</span>
                <a href="{{ route('logout') }}"><span
                        class="text-white text-[14px] mx-2 hover:text-red-400 cursor-pointer" title="Logout"><i
                            class="fa-solid fa-circle"></i></span></a>
            </div>
            <div id="call-setup-container" class="hidden">
                <h2 class="text-white">Select Cameras for the Call</h2>
                <div id="camera-list"></div>
                <button id="add-camera-btn" class="bg-green-500 text-white p-2 rounded" disabled>Add Camera</button>
                <button id="start-call-btn" class="bg-blue-500 text-white p-2 rounded mt-4">Start Call</button>
            </div>
            <!-- Video container here -->
            <!-- User list here -->
            @include('components.video-container')
            @include('components.user-list')
            @include('components.user-footer')

            <!-- User footer  here -->


        </div>
    </div>

</body>

</html>
