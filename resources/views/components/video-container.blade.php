<div id="video-call-container"
    class="hidden flex justify-center items-center flex-1 px-4 py-6">
    <div class="flex w-full text-white justify-center items-center gap-4 w-full">
        <div class="flex flex-col gap-4 w-full">
            <div class="relative rounded overflow-hidden flex flex-wrap justify-center gap-4 w-full">
                {{-- Receiver Videos --}}
                <div id="remoteVideoContainer" class="flex flex-col-reverse gap-2 p-2">
                    {{-- Dynamically appended video tags for remote participants will  go here --}}
                </div>
                {{-- Sender Videos --}}
                <div id="localVideoContainer" class="flex flex-col-reverse gap-2 p-2">
                    {{-- Dynamically appended video tags for local participants will go here --}}
                </div>
                {{-- Name for receiver --}}
                <div class="flex flex-col items-center">
                    <video></video>
                    <span id="video-call-name" class="block text-center text-black text-[14px] mt-2"></span>
                </div>

            </div>
            <div>
                <div><span></span></div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Controls -->
<div id="video-call-footer"
    class="hidden fixed inset-x-0 bottom-0 mb-[64px] bg-blue-500 flex justify-between items-center h-[65px] px-4 z-40">
    <!-- Center: Mute and Video Buttons -->
    <div class="flex-1 flex justify-center space-x-10 text-white">
        <div class="flex flex-col items-center cursor-pointer" id="muteMicBtn">
            <i class="fa-solid fa-microphone-slash text-xl"></i>
            <span class="text-xs mt-1">Unmute</span>
        </div>
        <div class="flex flex-col items-center cursor-pointer" id="muteCamBtn">
            <i class="fa-solid fa-video text-xl"></i>
            <span class="text-xs mt-1">Start Video</span>
        </div>
    </div>

    <!-- Right: Leave Button -->
    <div class="flex justify-end">
        <button id="hangupBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded">
            Leave
        </button>
    </div>
</div>
