<div id="profile-container" class="flex flex-col md:flex-row bg-[#F3F4F6] text-gray-900 w-full h-full">
    <!-- Sidebar -->
    <div class="flex w-full xl:w-[260px] 2xl:w-[260px] md:w-[260px] bg-white max-sm:order-1 justify-center shadow-md">
        <div class="flex flex-col pt-[80px] items-center w-full">
            <!-- Search -->
            <input id="searchField"
                class="bg-gray-200 text-gray rounded-lg w-[80%] h-[42px] px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                type="text" name="search" placeholder="Search Spesialis">

            <!-- User List -->
            <div id="results"
                class="mx-auto mt-6 w-[80%] h-full max-h-[550px] overflow-y-auto space-y-1 scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-800">
                @foreach ($users as $user)
                    <a href="{{ url('/profile/' . $user->username) }}">
                        <div
                            class="flex items-center hover:bg-slate-700 cursor-pointer transition duration-150 ease-in-out rounded-lg px-2 py-2">
                            <img src="{{ asset('/images/' . $user->profileImage) }}"
                                class="rounded-full w-[32px] h-[32px] object-cover">
                            <span class="ml-3 text-gray-900 text-sm font-medium">{{ $user->name }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Content Placeholder -->
    <div class="flex-1">
        @yield('content')
    </div>
</div>
