<div class="flex w-full text-white justify-center items-center mt-40 relative"> <!-- Increased mt-32 for more margin -->
    <div>
        <div class="relative rounded overflow-hidden">
{{--            <img src="{{ asset('images/' . $profile->profileImage) }}" class="w-[830px] h-[442px]">--}}
            <span class="absolute bottom-0 bg-black text-white rounded-tr-lg text-[14px] px-4 py-2">
{{--                {{ $profile->name }}--}}
            </span>
        </div>
        <div>
            <div class="flex items-center justify-center py-4 space-x-2">
                <!-- Call Setup (Select Cameras) -->
                <div id="call-setup-container" class="hidden bg-gray-900 text-white p-4">
                    <h2 class="text-lg font-semibold mb-2">Select Cameras for the Call</h2>
                    <div id="camera-list" class="space-y-2"></div>
                    <div class="mt-4 space-x-2">
                        <button id="add-camera-btn" class="bg-green-500 text-white px-4 py-2 rounded" disabled>Add Camera</button>
                        <button id="start-call-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Start Call</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
