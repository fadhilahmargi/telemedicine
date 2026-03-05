<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ $app_setting['app_name'] }} Login</title>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-blue-100 to-blue-300">

    <!-- Container -->
    <div class="flex w-full max-w-7xl shadow-lg rounded-lg overflow-hidden">

        <!-- Left Side: Illustration -->
        <div class="w-full sm:w-1/2 bg-blue-500 p-10 flex items-center justify-center">
            <img src="{{ asset('images/login.png') }}" alt="Telehealth Illustration"
                class="w-[450px] sm:w-[500px] h-auto transition-transform transform hover:scale-110 duration-500">
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full sm:w-1/2 bg-white p-10 flex flex-col justify-center">

            <!-- Logo Bar -->
            <div class="flex justify-center space-x-6 mb-8">
                <img src="{{ asset('images/logo-pens.png') }}" alt="Logo PENS"
                    class="h-20 border border-gray-300 p-2 rounded-lg shadow-md">
                <img src="{{ URL::asset($app_setting['app_logo']) ?? asset('images/logo-telemedicine.png') }}"
                    alt="Logo Telemedicine" class="h-20 border border-gray-300 p-2 rounded-lg shadow-md">
            </div>
            {{-- @if (session('message'))
                <div class="mb-4 text-red-600 font-semibold">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 text-red-600 font-semibold">
                    {{ session('error') }}
                </div>
            @endif --}}
            <!-- Highlighted Welcome Text -->
            <div class="bg-gray-100 p-6 rounded-xl shadow-inner border border-gray-300 text-center mb-8">
                <h1 class="text-2xl font-medium text-gray-700">Welcome to</h1>
                <h2 class="text-4xl font-bold text-blue-600">{{ $app_setting['app_name'] }}</h2>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="********"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                @if ($errors->any())
                    <div class="text-sm text-red-600 bg-red-100 px-3 py-2 rounded">
                        {{ $errors->first() }}
                    </div>
                @endif
                @if (session('message'))
                    <div class="mb-4 text-red-600 font-semibold">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 text-red-600 font-semibold">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Remember Me
                    </label>
                    <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-semibold">
                    Login
                </button>

                <p class="text-sm text-center">
                    Don't have an account?
                    <a href="/register" class="text-blue-600 hover:underline">Sign Up</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>
