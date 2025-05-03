<div id="video-call-container"
    class="hidden flex justify-between flex-1 xl:flex-row 2xl:flex-row lg:flex-row md:flex-row flex-col">
    <div class="flex w-full text-white  justify-center items-center">
        <div>
            <div class="relative rounded overflow-hidden flex flex-wrap justify-center gap-4">
                {{-- Receiver Videos --}}
                <div id="remoteVideoContainer" class="flex flex-wrap gap-2 bg-black p-2 rounded">
                    {{-- Dynamically appended video tags for remote participants will go here --}}
                </div>
                {{-- Sender Videos --}}
                <div id="localVideoContainer" class="flex flex-wrap gap-2 bg-black p-2 rounded">
                    {{-- Dynamically appended video tags for local participants will go here --}}
                </div>
                {{-- Name for receiver --}}
                <span id="video-call-name"
                    class="absolute bottom-[0px] bg-black text-white rounded-tr-lg text-[14px] px-4 py-2"></span>
            </div>
            <div>
                <div><span></span></div>
            </div>
        </div>
    </div>
</div>
<div id="video-call-footer" class="hidden bg-[#404749] flex h-[65px] justify-between items-center">
    {{-- Mic/Cam mute buttons --}}
    <div class="px-6 space-x-4">
        <span id="muteMicBtn" class="text-white hover:text-red-400"><i
                class="fa-solid fa-microphone-slash cursor-pointer"></i></span>
        <span id="muteCamBtn" class="text-white"><i class="fa-solid fa-video"></i></span>
    </div>
    <div>
    </div>
    {{-- Hang up button --}}
    <div class="px-6 space-x-4">
        <span id="hangupBtn" class="text-[#F87979] text-[14px] hover:underline cursor-pointer">End Meeting</span>
    </div>
</div>
