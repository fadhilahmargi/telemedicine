<div class="flex w-full text-white justify-center items-center mt-40 relative"> <!-- Increased mt-32 for more margin -->
    <div>
        <div class="relative rounded overflow-hidden">
            {{--            <img src="{{ asset('images/' . $profile->profileImage) }}" class="w-[830px] h-[442px]"> --}}
            <span class="absolute bottom-0 bg-black text-white rounded-tr-lg text-[14px] px-4 py-2">
                {{--                {{ $profile->name }} --}}
            </span>
        </div>
        <div>
            <div class="flex items-center justify-center py-4 space-x-2">
                <!-- Call Setup (Select Cameras) -->
                <div id="call-setup-container"
                    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                    <div
                        class="relative bg-white/95 rounded-3xl shadow-2xl p-8 w-full max-w-4xl flex flex-col items-center border-4 border-blue-300">
                        <!-- Tombol Close -->
                        <button onclick="document.getElementById('call-setup-container').classList.add('hidden')"
                            class="absolute top-4 right-4 text-blue-700 text-2xl hover:text-red-500 transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <!-- Judul -->
                        <h2 class="text-3xl font-extrabold text-blue-800 mb-6 tracking-wide text-center drop-shadow">
                            Select Cameras for the Call</h2>
                        <!-- Daftar Kamera (bisa discroll) -->
                        <div id="camera-list"
                            class="space-y-4 overflow-y-auto max-h-[350px] w-full mb-6 px-1 text-black">
                            <!-- Isi kamera akan di-generate JS -->
                        </div>
                        <!-- Tombol Aksi -->
                        <div class="flex gap-4 w-full justify-center">
                            <button id="add-camera-btn"
                                class="bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg text-base shadow transition flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> Add Camera
                            </button>
                            <button id="start-call-btn"
                                class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg text-base shadow transition flex items-center gap-2">
                                <i class="fa-solid fa-video"></i> Start Call
                            </button>
                        </div>
                    </div>
                    {{-- <h2 class="text-lg font-semibold mb-2">Select Cameras for the Call</h2>
                    <div id="camera-list" class="space-y-2"></div>
                    <div class="mt-4 space-x-2">
                        <button id="add-camera-btn" class="bg-green-500 text-white px-4 py-2 rounded" disabled>Add
                            Camera</button>
                        <button id="start-call-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Start Call</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
