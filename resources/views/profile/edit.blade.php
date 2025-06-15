@extends('components.layouts.base')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[60vh]">
        <div
            class="bg-gradient-to-br from-blue-100 via-white to-blue-50 rounded-3xl shadow-2xl p-10 w-full max-w-xl border border-blue-200">
            <h2 class="text-3xl font-extrabold mb-8 text-blue-800 text-center tracking-wide drop-shadow">Edit Profile</h2>
            @if (session('success'))
                <div
                    class="mb-6 text-green-600 font-semibold text-center bg-green-50 border border-green-200 rounded-lg py-2">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Profile Photo -->
                <div class="flex flex-col items-center mb-2">
                    <div class="relative group">
                        <img id="preview"
                            src="{{ Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage) . '?' . now()->timestamp : asset('images/default-profile.svg') }}"
                            alt="Profile Photo" class="w-24 h-24 rounded-full object-cover mb-2 border-2 border-blue-300">
                        <label for="photo"
                            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-40 rounded-full cursor-pointer transition">
                            <span class="text-white text-sm opacity-0 group-hover:opacity-100 transition">Change
                                Photo</span>
                        </label>
                        <input id="photo" type="file" name="photo" accept="image/png, image/jpeg, image/jpg"
                            class="hidden" onchange="previewImage(event)" />
                    </div>
                    <p class="text-xs text-gray-500 mt-2">JPG, PNG, max 2MB</p>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-blue-900 font-semibold mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                        required
                        class="w-full px-4 py-2 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-blue-900 font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                        required
                        class="w-full px-4 py-2 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <div class="pt-4 text-center">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-400 text-white font-bold px-10 py-2 rounded-xl shadow-lg hover:from-blue-700 hover:to-blue-500 transition">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

    {{-- Preview image JS --}}
@section('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
