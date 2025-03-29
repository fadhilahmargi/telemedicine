<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<script src="https://cdn.tailwindcss.com"></script>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Jquery -->
     <script
			  src="https://code.jquery.com/jquery-3.7.1.min.js"
			  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
			  crossorigin="anonymous"></script>
              {{-- @vite('resources/js/search.js') --}}
</head>
<body>
    <!--call popup-->
    <div class="min-h-screen w-full bg-[#00FFB3] flex items-center justify-center">
        <div
            class="lg:w-[1200px] lg:h-[800px] 2xl:w-[1200px] 2xl:h-[800px] xl:w-[1200px] xl:h-[800px] bg-[#000000] flex justify-between shadow-lg rounded overflow-hidden flex-col">
            <div class="bg-[#404749] h-[40px] flex justify-between items-center">
                <span class="text-white text-[14px] mx-4">Telemedicine</span>
                <a href="{{route('logout')}}"><span class="text-white text-[14px] mx-2 hover:text-red-400 cursor-pointer"
                        title="Logout"><i class="fa-solid fa-circle"></i></span></a>
            </div>
            <!-- Video container here -->
            <!-- User list here -->
            @include('components.user-list')
            @include('components.user-footer')

            <!-- User footer  here -->


        </div>
    </div>


<!-- Scripts here -->
<script src="{{ asset('js/search.js') }}"></script>
</body>
</html>




{{-- <!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="[CSRF-TOKEN]">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</head>

<body>
    <!--call popup-->
    <div class="min-h-screen w-full bg-[#00FFB3] flex items-center justify-center">
        <div
            class="lg:w-[1200px] lg:h-[800px] 2xl:w-[1200px] 2xl:h-[800px] xl:w-[1200px] xl:h-[800px] bg-[#ffffff] flex justify-between shadow-lg rounded overflow-hidden flex-col">
            <div class="bg-[#404749] h-[40px] flex justify-between items-center">
                <span class="text-white text-[14px] mx-4">Telemedicine</span>
                <a href="{{route('logout')}}"><span class="text-white text-[14px] mx-2 hover:text-red-400 cursor-pointer"
                        title="Logout"><i class="fa-solid fa-circle"></i></span></a>
            </div>
            <!-- Video container here -->
            <!-- User list here -->
            @include('components.user-list')
            @include('components.user-footer')

            <!-- User footer  here -->


        </div>
    </div>

    {{-- <!-- Menjalankan Conference -->
    <script>
        let videoStreams = []; // Store active video streams
        let videoContainer = document.getElementById('video-container');
        let deviceList = document.getElementById('device-list');


        // Function to list available video devices
        async function listDevices() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');

            // Preserve the selected device (if any)
            const selectedDevice = document.querySelector('input[name="videoDevice"]:checked');
            const selectedDeviceId = selectedDevice ? selectedDevice.value : null;

            deviceList.innerHTML = ''; // Clear previous list

            videoDevices.forEach((device, index) => {
                let deviceOption = document.createElement('div');
                deviceOption.innerHTML = `
            <input type="radio" name="videoDevice" id="device-${index}" value="${device.deviceId}">
            <label for="device-${index}">${device.label || `Camera ${index + 1}`}</label>
        `;
                deviceList.appendChild(deviceOption);

                // Re-select the previously selected device if it matches
                if (device.deviceId === selectedDeviceId) {
                    document.getElementById(`device-${index}`).checked = true;
                }
            });
        }

        // Function to add a video source
        async function addVideoSource() {
            const selectedDevice = document.querySelector('input[name="videoDevice"]:checked');
            if (!selectedDevice) {
                alert('Please select a video source!');
                return;
            }

            const deviceId = selectedDevice.value;

            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        deviceId: {
                            exact: deviceId
                        }
                    },
                });

                videoStreams.push(stream);

                // Create a new video element
                const videoElement = document.createElement('video');
                videoElement.srcObject = stream;
                videoElement.autoplay = true;
                videoContainer.appendChild(videoElement);
            } catch (error) {
                console.error('Error accessing video source:', error);
            }
        }

        // Event Listener for "Add Video Source" button
        document.getElementById('add-source-btn').addEventListener('click', async () => {
            await listDevices(); // Refresh device list
            await addVideoSource(); // Add selected video source
        });

        // Load available devices on page load
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // request permission to access mic and camera
                await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                });
                console.log('Permission granted');
            } catch (error) {
                console.error('Error accessing video source:', error);
            }

            await listDevices();
        });
    </script>
</body>

</html> --}}
