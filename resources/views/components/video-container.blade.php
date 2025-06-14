<div id="video-call-container" class="hidden flex justify-center items-center flex-1 px-4 py-6">
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
    <!-- Center: Mute, Video, and Note Buttons -->
    <div class="flex-1 flex justify-center space-x-10 text-white">
        <div class="flex flex-col items-center cursor-pointer" id="muteMicBtn">
            <i class="fa-solid fa-microphone-slash text-xl"></i>
            <span class="text-xs mt-1">Unmute</span>
        </div>
        <div class="flex flex-col items-center cursor-pointer" id="muteCamBtn">
            <i class="fa-solid fa-video text-xl"></i>
            <span class="text-xs mt-1">Start Video</span>
        </div>
        <!-- Note Button (Kertas & Pensil) -->
        <button id="openNoteModalBtn" class="flex flex-col items-center text-white focus:outline-none">
            <i class="fa-regular fa-pen-to-square text-2xl"></i>
            <span class="text-xs">Note</span>
        </button>
    </div>

    <!-- Right: Leave Button -->
    <div class="flex justify-end">
        <button id="hangupBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded">
            Leave
        </button>
    </div>
</div>

<!-- Modal Catatan Dokter -->
<div id="noteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl p-8 w-full max-w-4xl shadow-lg relative">
        <button id="closeNoteModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-2xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2 class="text-xl font-bold mb-6 text-blue-700">Catatan Dokter Spesialis</h2>
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Info Pasien (Kiri) -->
            <div id="patientInfo"
                class="w-full md:w-80 bg-blue-50 border border-blue-200 rounded-lg shadow p-4 text-sm text-gray-700 h-fit">
                Memuat data pasien...
            </div>
            <!-- Form Catatan Dokter (Kanan, 2 Kolom) -->
            <form id="doctorNoteForm" class="flex-1 flex flex-col gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Dokter</label>
                    <textarea id="doctorNote" rows="10" class="w-full border rounded p-2"
                        placeholder="Tulis catatan dokter di sini..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">
                        Silakan tulis seluruh catatan medis (keluhan, anamnesis, pemeriksaan fisik, diagnosis, terapi,
                        saran, dll) dalam satu kolom ini.
                    </p>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" id="saveNoteBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk mengambil query parameter dari URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Ambil patient id dari URL
    const patientId = getQueryParam('patient');

    // Fungsi untuk ambil data pasien dari backend
    async function fetchPatientInfo(patientId) {
        try {
            const response = await fetch(`/getPatient/${patientId}`);
            if (!response.ok) throw new Error('Gagal mengambil data pasien');
            const patient = await response.json();
            document.getElementById('patientInfo').innerHTML = `
                <div class="bg-white border border-blue-200 rounded-lg shadow p-4">
                    <div class="flex items-center mb-3">
                        <i class="fa-solid fa-user text-blue-500 mr-3 text-lg"></i>
                        <div>
                            <div class="text-xs text-gray-500">Nama</div>
                            <div class="font-semibold text-gray-800">${patient.name}</div>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <i class="fa-solid fa-envelope text-blue-500 mr-3 text-lg"></i>
                        <div>
                            <div class="text-xs text-gray-500">Email</div>
                            <div class="text-gray-800">${patient.email}</div>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <i class="fa-solid fa-phone text-blue-500 mr-3 text-lg"></i>
                        <div>
                            <div class="text-xs text-gray-500">Telepon</div>
                            <div class="text-gray-800">${patient.phone}</div>
                        </div>
                    </div>
                    <div class="flex items-center mb-3">
                        <i class="fa-solid fa-location-dot text-blue-500 mr-3 text-lg"></i>
                        <div>
                            <div class="text-xs text-gray-500">Alamat</div>
                            <div class="text-gray-800">${patient.address}</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fa-solid fa-calendar-days text-blue-500 mr-3 text-lg"></i>
                        <div>
                            <div class="text-xs text-gray-500">Tanggal Lahir</div>
                            <div class="text-gray-800">${patient.dob ? patient.dob.substring(0,10) : ''}</div>
                        </div>
                    </div>
                </div>
            `;
        } catch (err) {
            document.getElementById('patientInfo').innerHTML = 'Gagal memuat data pasien.';
        }
    }

    document.getElementById('openNoteModalBtn').onclick = function() {
        fetchPatientInfo(patientId);
        document.getElementById('noteModal').classList.remove('hidden');
    };
    document.getElementById('closeNoteModalBtn').onclick = function() {
        document.getElementById('noteModal').classList.add('hidden');
    };
    document.getElementById('saveNoteBtn').onclick = function() {
        const note = document.getElementById('doctorNote').value;
        alert('Catatan disimpan:\n' + note);
        document.getElementById('noteModal').classList.add('hidden');
    };
</script>
