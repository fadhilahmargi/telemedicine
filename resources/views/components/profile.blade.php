<div class="flex w-full text-white justify-center items-center mt-40 relative"> <!-- Increased mt-32 for more margin -->
    <div>
        <div class="relative rounded overflow-hidden">
            <img src="{{ asset('images/' . $profile->profileImage) }}" class="w-[830px] h-[442px]">
            <span class="absolute bottom-0 bg-black text-white rounded-tr-lg text-[14px] px-4 py-2">
                {{ $profile->name }}
            </span>
        </div>
        <div>
            <div class="flex items-center justify-center py-4 space-x-2">
                @if ($auth->id !== $profile->id)
                    <span id="callBtn" data-user="{{ $profile->id }}"
                        class="bg-white px-3 py-2 cursor-pointer hover:bg-green-400 hover:text-white rounded-full text-black transition duration-150 ease-out hover:ease-in"><i
                            class="fa-solid fa-phone-flip"></i></span>
                @endif
            </div>
        </div>
    </div>
</div>

