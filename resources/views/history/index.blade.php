{{-- filepath: resources/views/history/index.blade.php --}}
@extends('components.layouts.base')

@section('title', 'Riwayat Meeting')

@section('content')
{{--    @php--}}
{{--        $consultations = [--}}
{{--            [--}}
{{--                'patient_name' => 'Budi Santoso',--}}
{{--                'notes' => 'Kontrol tekanan darah.',--}}
{{--                'spesialis_name' => 'dr. Fadhilah',--}}
{{--                'penjaga_name' => 'dr. Margi',--}}
{{--                'consultation_date' => '2025-06-10 09:00',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Siti Aminah',--}}
{{--                'notes' => 'Keluhan batuk pilek.',--}}
{{--                'spesialis_name' => 'dr. Spesialis',--}}
{{--                'penjaga_name' => 'dr. Penjaga',--}}
{{--                'consultation_date' => '2025-06-12 14:30',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Andi Wijaya',--}}
{{--                'notes' => 'Cek gula darah rutin.',--}}
{{--                'spesialis_name' => 'dr. Fadhilah',--}}
{{--                'penjaga_name' => 'dr. Margi',--}}
{{--                'consultation_date' => '2025-06-14 11:15',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Rina Kusuma',--}}
{{--                'notes' => 'Konsultasi alergi makanan.',--}}
{{--                'spesialis_name' => 'dr. Spesialis',--}}
{{--                'penjaga_name' => 'dr. Penjaga',--}}
{{--                'consultation_date' => '2025-06-15 08:30',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Dewi Lestari',--}}
{{--                'notes' => 'Pemeriksaan kehamilan.',--}}
{{--                'spesialis_name' => 'dr. Fadhilah',--}}
{{--                'penjaga_name' => 'dr. Margi',--}}
{{--                'consultation_date' => '2025-06-16 10:00',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Agus Pratama',--}}
{{--                'notes' => 'Keluhan nyeri sendi.',--}}
{{--                'spesialis_name' => 'dr. Spesialis',--}}
{{--                'penjaga_name' => 'dr. Penjaga',--}}
{{--                'consultation_date' => '2025-06-17 13:45',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Lina Marlina',--}}
{{--                'notes' => 'Kontrol pasca operasi.',--}}
{{--                'spesialis_name' => 'dr. Fadhilah',--}}
{{--                'penjaga_name' => 'dr. Margi',--}}
{{--                'consultation_date' => '2025-06-18 15:20',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Nama Pasien 8',--}}
{{--                'notes' => 'Catatan tambahan.',--}}
{{--                'spesialis_name' => 'dr. Spesialis',--}}
{{--                'penjaga_name' => 'dr. Penjaga',--}}
{{--                'consultation_date' => '2025-06-19 10:00',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Nama Pasien 9',--}}
{{--                'notes' => 'Catatan tambahan.',--}}
{{--                'spesialis_name' => 'dr. Fadhilah',--}}
{{--                'penjaga_name' => 'dr. Margi',--}}
{{--                'consultation_date' => '2025-06-20 11:00',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Nama Pasien 8',--}}
{{--                'notes' => 'Catatan tambahan.',--}}
{{--                'spesialis_name' => 'dr. Spesialis',--}}
{{--                'penjaga_name' => 'dr. Penjaga',--}}
{{--                'consultation_date' => '2025-06-19 10:00',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Nama Pasien 9',--}}
{{--                'notes' => 'Catatan tambahan.',--}}
{{--                'spesialis_name' => 'dr. Fadhilah',--}}
{{--                'penjaga_name' => 'dr. Margi',--}}
{{--                'consultation_date' => '2025-06-20 11:00',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Nama Pasien 8',--}}
{{--                'notes' => 'Catatan tambahan.',--}}
{{--                'spesialis_name' => 'dr. Spesialis',--}}
{{--                'penjaga_name' => 'dr. Penjaga',--}}
{{--                'consultation_date' => '2025-06-19 10:00',--}}
{{--            ],--}}
{{--            [--}}
{{--                'patient_name' => 'Nama Pasien 9',--}}
{{--                'notes' => 'Catatan tambahan.',--}}
{{--                'spesialis_name' => 'dr. Fadhilah',--}}
{{--                'penjaga_name' => 'dr. Margi',--}}
{{--                'consultation_date' => '2025-06-20 11:00',--}}
{{--            ],--}}
{{--        ];--}}
{{--    @endphp--}}

    <div class="w-full flex flex-col items-center">
        <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-lg p-8 w-full max-w-4xl">
            <h2 class="text-2xl font-bold text-blue-900 mb-4 flex items-center justify-center gap-3 text-center">
                <span>
                    <i class="fa-solid fa-clock-rotate-left text-blue-700 text-3xl"></i>
                </span>
                <span class="drop-shadow">Riwayat Meeting</span>
            </h2>
            <hr class="mb-4 border-blue-300">
            <div class="overflow-x-auto">
                <table class="min-w-full rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-600 to-blue-400 text-white">
                            <th class="px-6 py-3 text-left font-semibold">NO</th>
                            <th class="px-6 py-3 text-left font-semibold">NAMA PASIEN</th>
                            <th class="px-6 py-3 text-left font-semibold">CATATAN</th>
                            <th class="px-6 py-3 text-left font-semibold">DOKTER SPESIALIS</th>
                            <th class="px-6 py-3 text-left font-semibold">DOKTER PENJAGA</th>
                            <th class="px-6 py-3 text-left font-semibold">TANGGAL KONSULTASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consultations as $i => $c)
                            <tr class="{{ $i % 2 == 0 ? 'bg-blue-50' : 'bg-white' }}">
                                <td class="px-6 py-3 font-semibold text-blue-900">{{ $i + 1 }}</td>
                                <td class="px-6 py-3">{{ $c->patient->name }}</td>
                                <td class="px-6 py-3">{{ $c->notes }}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="inline-block px-3 py-1 rounded-full bg-blue-800 text-white text-xs font-semibold">
                                        {{ $c->spesialis->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="inline-block px-3 py-1 rounded-full bg-blue-400 text-white text-xs font-semibold">
                                        {{ $c->penjaga->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">{{ $c->consultation_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
