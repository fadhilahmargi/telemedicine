<div class="flex min-h-screen">

    <!-- Bagian Kiri: Gambar -->
    <div class="w-full sm:w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('images/register.png') }}');">
        <!-- Gambar di sini -->
    </div>

    <!-- Bagian Kanan: Form -->
    <div class="w-full sm:w-1/2 bg-white p-10 flex flex-col justify-center">
        <!-- Logo Bar -->
        <div class="flex justify-center space-x-6 mb-8">
            <img src="{{ asset('images/logo-pens.png') }}" alt="Logo PENS"
                class="h-20 border border-gray-300 p-2 rounded-lg shadow-md">
            <img src="{{ asset('images/logo-telemedicine.png') }}" alt="Logo Telemedicine"
                class="h-20 border border-gray-300 p-2 rounded-lg shadow-md">
        </div>

        <!-- Heading -->
        <div class="bg-gray-100 p-6 rounded-xl shadow-inner border border-gray-300 text-center mb-8">
            <h1 class="text-2xl font-medium text-gray-700">Create Your Account</h1>
            <h2 class="text-4xl font-bold text-blue-600">EEPIS Telehealth</h2>
        </div>

        <!-- Form -->
        @yield('form')

        <!-- Sign-in Link -->
        <div class="text-center mt-4">
            <span class="text-sm">Already have an account? <a href="{{ route('login') }}"
                    class="text-blue-600 hover:underline">Sign in</a></span>
        </div>
    </div>
</div>
