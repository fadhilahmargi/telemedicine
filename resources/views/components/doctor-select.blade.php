@extends('components.layouts.base')

@section('content')
    <div class="flex justify-center items-center min-h-[100vh] bg-blue-100">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full flex flex-col md:flex-row gap-8 relative">
            <!-- KIRI: Search & List Dokter -->
            <div class="flex-1 flex flex-col">
                <div class="mb-6 text-center">
                    <div class="bg-blue-200 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3 shadow">
                        <i class="fa-solid fa-user-doctor text-3xl text-blue-700"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-blue-700 mb-2">Pilih Dokter Spesialis</h2>
                    <p class="text-gray-500 text-sm mb-2">Silakan pilih dokter spesialis untuk konsultasi.</p>
                </div>
                <input type="text" id="search-doctor" placeholder="Cari nama dokter..."
                    class="w-full p-2 border-2 border-blue-200 rounded-lg mb-4 text-black focus:ring-2 focus:ring-blue-400 transition" />
                <div id="doctor-list" class="flex flex-col gap-3 mb-4 max-h-96 overflow-y-auto">
                    {{-- Card dokter akan di-render oleh JS --}}
                </div>
                <div class="mt-4 text-gray-400 text-xs text-center">
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    Data dokter diambil otomatis dari sistem. Scroll untuk melihat lebih banyak dokter.
                </div>
            </div>
            <!-- KANAN: Detail Dokter -->
            <div class="flex-[2] flex flex-col items-center justify-center min-h-[350px]">
                <div id="doctor-detail"
                    class="hidden w-full max-w-2xl mx-auto bg-blue-50 rounded-2xl shadow p-10 flex flex-col items-center">
                    <img id="detail-img" src=""
                        class="w-32 h-32 rounded-full object-cover border-4 border-blue-200 mb-4" alt="Foto Dokter">
                    <div class="text-3xl font-bold text-blue-800 mb-2" id="detail-name"></div>
                    <div class="text-lg text-blue-500 mb-3" id="detail-specialization"></div>
                    <div class="text-gray-600 mb-6 text-center" id="detail-bio"></div>
                    <button id="call-btn"
                        class="bg-green-500 text-white px-10 py-4 rounded-lg text-xl font-semibold shadow hover:bg-green-600 transition w-full">
                        <i class="fa-solid fa-phone-flip mr-2"></i> Call
                    </button>
                </div>
                <div id="doctor-placeholder" class="text-gray-400 text-center" style="display:block;">
                    <i class="fa-regular fa-address-card text-6xl mb-6"></i>
                    <div class="mt-4 text-lg">Pilih salah satu dokter untuk melihat detail.</div>
                </div>
            </div>
            </>
        </div>

        <script>
            const allDoctors = @json($doctors);
            let loadedCount = 0;
            const LOAD_BATCH = 10;
            let selectedDoctor = null;

            function renderDoctors(doctors, reset = false) {
                const list = document.getElementById('doctor-list');
                if (reset) {
                    list.innerHTML = '';
                    loadedCount = 0;
                }
                const fragment = document.createDocumentFragment();
                const toLoad = doctors.slice(loadedCount, loadedCount + LOAD_BATCH);
                toLoad.forEach(doctor => {
                    const card = document.createElement('button');
                    card.type = 'button';
                    card.className =
                        'flex items-center gap-4 w-full px-4 py-4 rounded-xl border border-blue-200 bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-800 font-semibold transition focus:outline-none shadow';
                    card.innerHTML = `
                <img src="/images/${doctor.profileImage}" class="w-14 h-14 rounded-full object-cover border-2 border-blue-300" alt="${doctor.name}">
                <div class="flex flex-col items-start flex-1">
                    <span class="font-bold text-lg">${doctor.name}</span>
                    <span class="text-xs text-blue-500">${doctor.specialization ?? 'Spesialis'}</span>
                </div>
            `;
                    card.onclick = function() {
                        // Hilangkan highlight dari semua card
                        Array.from(list.children).forEach(child => {
                            child.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-600', 'text-white');
                            child.classList.add('bg-blue-50', 'text-blue-800');
                        });
                        // Tambahkan highlight pada card yang dipilih
                        card.classList.add('ring-2', 'ring-blue-500', 'bg-blue-600', 'text-white');
                        card.classList.remove('bg-blue-50', 'text-blue-800');
                        showDoctorDetail(doctor);
                    };
                    fragment.appendChild(card);
                });
                list.appendChild(fragment);
                loadedCount += toLoad.length;
            }

            function filterDoctors(keyword) {
                keyword = keyword.toLowerCase();
                return allDoctors.filter(d => d.name.toLowerCase().includes(keyword));
            }

            function showDoctorDetail(doctor) {
                selectedDoctor = doctor;
                document.getElementById('doctor-detail').classList.remove('hidden');
                document.getElementById('doctor-placeholder').style.display = 'none';
                document.getElementById('detail-img').src = '/images/' + doctor.profileImage;
                document.getElementById('detail-name').textContent = doctor.name;
                document.getElementById('detail-specialization').textContent = doctor.specialization ?? 'Spesialis';
                document.getElementById('detail-bio').textContent = doctor.bio ?? '';
            }

            document.addEventListener('DOMContentLoaded', function() {
                renderDoctors(allDoctors, true);

                const list = document.getElementById('doctor-list');
                const search = document.getElementById('search-doctor');
                let currentDoctors = [];

                search.addEventListener('input', function() {
                    const keyword = search.value;
                    currentDoctors = filterDoctors(keyword);
                    renderDoctors(currentDoctors, true);
                    document.getElementById('doctor-detail').classList.add('hidden');
                    document.getElementById('doctor-placeholder').style.display = 'block';
                });

                list.addEventListener('scroll', function() {
                    const keyword = search.value;
                    currentDoctors = keyword ? filterDoctors(keyword) : allDoctors;
                    if (list.scrollTop + list.clientHeight >= list.scrollHeight - 10) {
                        renderDoctors(currentDoctors, false);
                    }
                });

                document.getElementById('call-btn').addEventListener('click', function() {
                    if (!selectedDoctor) return;
                    window.location.href = '/video-container?doctor=' + selectedDoctor.id;
                });
            });
        </script>
    @endsection
