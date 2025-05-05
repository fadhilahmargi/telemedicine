{{-- <div class="bg-[#1E3A8A] flex justify-between items-center px-6 py-3 shadow-inner text-white text-sm">
    <!-- Kiri: Profil -->
    <div class="flex items-center space-x-3">
        <img src="{{ url('images/' . $auth->profileImage) }}"
            class="rounded-full w-10 h-10 border-2 border-white shadow-md">
        <a href="{{ url('profile/' . $auth->username) }}" class="hover:underline font-medium">{{ $auth->name }}</a>
    </div>

    <!-- Time and Date in a single row -->
    <div
        class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl shadow-md flex justify-center items-center text-white text-xs sm:text-sm font-semibold">
        <span id="date" class="tracking-wide font-sans mr-4 text-[13px] sm:text-sm"></span>
        <span id="clock" class="tracking-widest font-mono text-[15px] sm:text-base"></span>
    </div>

    <!-- Kanan: Settings -->
    <div>
        <a href="/account/settings/" class="text-lg hover:text-blue-300 transition" title="Account Settings">
            <i class="fa-solid fa-user-gear"></i>
        </a>
    </div>

</div>

<script>
    function updateDateTime() {
        const now = new Date();

        const optionsDate = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const optionsTime = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        document.getElementById('date').textContent = now.toLocaleDateString('en-US', optionsDate);
        document.getElementById('clock').textContent = now.toLocaleTimeString('en-US', optionsTime);
    }

    setInterval(updateDateTime, 1000);
    updateDateTime(); // Call once on load
</script> --}}
<!-- Footer with Fixed Position -->
<div class="bg-[#1E3A8A] flex justify-between items-center px-6 py-3 shadow-inner text-white text-sm fixed bottom-0 left-0 w-full z-10">
    <!-- Left: Profile Section -->
    <div class="flex items-center space-x-3">
        <img src="{{ url('images/' . $auth->profileImage) }}"
            class="rounded-full w-10 h-10 border-2 border-white shadow-md">
        <a href="{{ url('profile/' . $auth->username) }}" class="hover:underline font-medium">{{ $auth->name }}</a>
    </div>

    <!-- Time and Date in a single row -->
    <div
        class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl shadow-md flex justify-center items-center text-white text-xs sm:text-sm font-semibold">
        <span id="date" class="tracking-wide font-sans mr-4 text-[13px] sm:text-sm"></span>
        <span id="clock" class="tracking-widest font-mono text-[15px] sm:text-base"></span>
    </div>

    <!-- Right: Settings -->
    <div>
        <a href="/account/settings/" class="text-lg hover:text-blue-300 transition" title="Account Settings">
            <i class="fa-solid fa-user-gear"></i>
        </a>
    </div>
</div>

<script>
    function updateDateTime() {
        const now = new Date();

        const optionsDate = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const optionsTime = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        document.getElementById('date').textContent = now.toLocaleDateString('en-US', optionsDate);
        document.getElementById('clock').textContent = now.toLocaleTimeString('en-US', optionsTime);
    }

    setInterval(updateDateTime, 1000);
    updateDateTime(); // Call once on load
</script>
