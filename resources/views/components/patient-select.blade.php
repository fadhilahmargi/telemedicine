@extends('components.layouts.base')

@section('content')
    <div class="flex justify-center items-center min-h-[100vh] bg-blue-100">
        <div class="bg-white rounded-3xl shadow-2xl p-10 text-center max-w-lg w-full relative">
            <div class="flex flex-col items-center mb-6">
                <div class="bg-blue-200 rounded-full w-16 h-16 flex items-center justify-center mb-3 shadow">
                    <i class="fa-solid fa-user-injured text-3xl text-blue-700"></i>
                </div>
                <h2 class="text-2xl font-bold text-blue-700 mb-2">Pilih Pasien</h2>
                <p class="text-gray-500 text-sm mb-2">Silakan pilih pasien yang akan dikonsultasikan ke dokter spesialis.</p>
            </div>
            <form id="patient-form" action="{{ route('doctor.select') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="patient" id="selected-patient">
                <input type="text" id="search-patient" placeholder="Cari nama pasien..."
                    class="w-full p-2 border-2 border-blue-200 rounded-lg mb-4 text-black focus:ring-2 focus:ring-blue-400 transition" />
                <div id="patient-list" class="flex flex-col gap-3 mb-4 max-h-64 overflow-y-auto"></div>
                <button type="submit" id="submit-btn" disabled
                    class="bg-blue-600 text-white px-4 py-3 rounded-lg w-full font-semibold shadow hover:bg-blue-700 transition opacity-50 cursor-not-allowed">
                    <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>
                    Lanjut ke Conference
                </button>
            </form>
            <div class="mt-8 text-gray-400 text-xs">
                <i class="fa-solid fa-circle-info mr-1"></i>
                Data pasien diambil otomatis dari sistem. Scroll untuk melihat lebih banyak pasien.
            </div>
        </div>
    </div>

    <script>
        let allPatients = [];
        let loadedCount = 0;
        const LOAD_BATCH = 10;

        function renderPatients(patients, reset = false) {
            const list = document.getElementById('patient-list');
            if (reset) {
                list.innerHTML = '';
                loadedCount = 0;
            }
            const fragment = document.createDocumentFragment();
            const toLoad = patients.slice(loadedCount, loadedCount + LOAD_BATCH);
            toLoad.forEach(patient => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className =
                    'flex items-center justify-between w-full px-4 py-3 rounded-lg border border-blue-200 bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-800 font-semibold transition focus:outline-none';
                btn.textContent = patient.name;
                btn.onclick = function() {
                    // Hilangkan highlight dari semua button
                    Array.from(list.children).forEach(child => {
                        child.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-600', 'text-white');
                        child.classList.add('bg-blue-50', 'text-blue-800');
                    });
                    // Tambahkan highlight & warna biru solid pada button yang dipilih
                    btn.classList.add('ring-2', 'ring-blue-500', 'bg-blue-600', 'text-white');
                    btn.classList.remove('bg-blue-50', 'text-blue-800');
                    document.getElementById('selected-patient').value = patient.id;
                    const submitBtn = document.getElementById('submit-btn');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                };
                fragment.appendChild(btn);
            });
            list.appendChild(fragment);
            loadedCount += toLoad.length;
        }

        function filterPatients(keyword) {
            keyword = keyword.toLowerCase();
            return allPatients.filter(p => p.name.toLowerCase().includes(keyword));
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetch('/getPatients')
                .then(response => response.json())
                .then(data => {
                    allPatients = data;
                    renderPatients(allPatients, true);
                });

            const list = document.getElementById('patient-list');
            const search = document.getElementById('search-patient');
            let currentPatients = [];

            search.addEventListener('input', function() {
                const keyword = search.value;
                currentPatients = filterPatients(keyword);
                renderPatients(currentPatients, true);
            });

            list.addEventListener('scroll', function() {
                const keyword = search.value;
                currentPatients = keyword ? filterPatients(keyword) : allPatients;
                if (list.scrollTop + list.clientHeight >= list.scrollHeight - 10) {
                    renderPatients(currentPatients, false);
                }
            });
        });
    </script>
@endsection
