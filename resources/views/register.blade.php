{{-- @extends('components.layouts.index')
@section('title')
    Register - Telemedicine
@endsection

@section('content')
    @include('components.forms.register-content')
@endsection

@section('form')
    @include('components.forms.register-form')
@endsection --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ $app_setting['app_name'] }} Register</title>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-blue-100 to-blue-300">

    <!-- Container -->
    <div class="flex w-full max-w-7xl shadow-lg rounded-lg overflow-hidden">

        <!-- Right Side: Register Form -->
        <div class="w-full sm:w-1/2 bg-white px-8 py-6 flex flex-col justify-center">

            <!-- Logo Bar -->
            <div class="flex justify-center space-x-4 mb-4">
                <img src="{{ asset('images/logo-pens.png') }}" alt="Logo PENS"
                    class="h-16 border border-gray-300 p-1 rounded-md shadow-md">
                <img src="{{ URL::asset($app_setting['app_logo']) ?? asset('images/logo-telemedicine.png') }}" alt="Logo Telemedicine"
                    class="h-16 border border-gray-300 p-1 rounded-md shadow-md">
            </div>

            <!-- Welcome Text -->
            <div class="bg-gray-100 p-4 rounded-lg shadow-inner border border-gray-300 text-center mb-4">
                <h1 class="text-xl font-medium text-gray-700">Create Your Account</h1>
                <h2 class="text-2xl font-bold text-blue-600">{{ $app_setting['app_name'] }}</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" placeholder="Your Name"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('name') }}" required>
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('username') }}" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('email') }}" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="********"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="********"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                @if ($errors->any())
                    <div class="text-sm text-red-600 bg-red-100 px-3 py-2 rounded">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-semibold text-sm">
                    Create Account
                </button>

                <p class="text-xs text-center">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign In</a>
                </p>
            </form>
        </div>

        <!-- Left Side: Illustration -->
        <div class="w-full sm:w-1/2 bg-blue-500 p-8 flex items-center justify-center">
            <img src="{{ asset('images/register.png') }}" alt="Telehealth Illustration"
                class="w-[450px] sm:w-[480px] h-auto transition-transform transform hover:scale-110 duration-500">
        </div>

    </div>

</body>

</html>
