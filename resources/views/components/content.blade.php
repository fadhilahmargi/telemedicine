<div class="flex justify-center items-center bg-gradient-to-b from-blue-100 to-blue-300 px-4 pt-4 pb-16">
    <div class="bg-white rounded-3xl shadow-2xl p-10 text-center max-w-5xl w-full transition-all duration-300">

        <!-- Judul -->
        <h1
            class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-500 to-blue-600 mb-6 tracking-tight drop-shadow-md flex justify-center items-center gap-3 border-b-4 border-blue-600 pb-4">
            <span>Welcome to <span class="text-blue-600">EEPIS Telehealth</span></span>
        </h1>

        <!-- Combined Text without Border -->
        <div class="text-sm md:text-base text-gray-700 leading-relaxed mb-6 max-w-3xl mx-auto">
            <p class="font-light">
                <span class="font-bold text-blue-600">EEPIS Telehealth</span> is the <span
                    class="font-bold text-blue-600">first multi-camera</span> teleconference by EEPIS Telemedicine. Our
                advanced Telemedicine platform bridges rural hospitals with expert care. Featuring seamless
                <span class="font-bold text-blue-600">multi-camera support</span> and instant connectivity, we ensure
                high-quality, secure medical communication—anytime, anywhere. Stay connected with the best in medical
                technology.
            </p>
        </div>


        <img src="{{ asset('images/banner.jpg') }}" alt="Telemedicine Banner"
            class="mx-auto mt-6 rounded-xl shadow-lg w-full max-w-4xl h-auto">

        <!-- CTA Button -->
        <a href="/start-consultation"
            class="inline-block bg-blue-600 text-white text-base font-semibold py-3 px-8 rounded-xl shadow-xl hover:bg-blue-700 transition duration-300 mt-8">
            Start Conference with a Selected User
        </a>

        <!-- Feature Highlights -->
        <div class="flex flex-wrap md:flex-nowrap space-y-6 md:space-y-0 md:space-x-6 mt-12">
            <div
                class="w-full md:w-1/3 bg-white border border-gray-200 p-6 rounded-2xl shadow-md text-center hover:shadow-lg transition">
                <i class="fas fa-video text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-lg font-semibold mb-2">Multi-Camera Support</h3>
                <p class="text-gray-600">Easily add multiple webcams per device—automatically detected, no manual setup
                    needed.</p>
            </div>
            <div
                class="w-full md:w-1/3 bg-white border border-gray-200 p-6 rounded-2xl shadow-md text-center hover:shadow-lg transition">
                <i class="fas fa-map-marker-alt text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-lg font-semibold mb-2">Remote Hospital Access</h3>
                <p class="text-gray-600">Connect underserved hospitals with specialists in real-time through secure
                    video calls.</p>
            </div>
            <div
                class="w-full md:w-1/3 bg-white border border-gray-200 p-6 rounded-2xl shadow-md text-center hover:shadow-lg transition">
                <i class="fas fa-plug text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-lg font-semibold mb-2">Plug & Play Simplicity</h3>
                <p class="text-gray-600">Just plug in your camera and go—perfect for non-technical staff and quick
                    setups.</p>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div class="mt-14">
            <h2 class="text-2xl font-bold text-blue-600 mb-4">What Our Users Are Saying</h2>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div class="bg-blue-50 p-6 rounded-xl shadow-md w-full">
                    <p class="text-gray-700 italic">"The multi-camera feature lets us show patients from multiple angles
                        to remote specialists. It's a game-changer for our hospital."</p>
                    <p class="text-blue-600 mt-3 font-medium">– Dr. Budi, Regional Hospital in Kalimantan</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-xl shadow-md w-full">
                    <p class="text-gray-700 italic">"It’s super intuitive. As soon as we connect a webcam, it just
                        works—perfect for non-technical staff in the clinic."</p>
                    <p class="text-blue-600 mt-3 font-medium">– Dr. Intan, Coastal Community Clinic</p>
                </div>
            </div>
        </div>

        <!-- Bottom Text -->
        <div class="mt-12 pt-8 border-t-4 border-blue-600">
            <p class="text-sm md:text-base text-gray-600">
                At Telemedicine, we bring you closer to the people who matter most with our high-quality video call
                technology. Connect instantly with our user-friendly interface and enjoy secure, private conversations.
            </p>
        </div>
    </div>
</div>
