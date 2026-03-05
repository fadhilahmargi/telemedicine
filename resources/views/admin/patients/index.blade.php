@extends('admin.layouts.app')

@section('content')
    {{-- modal add patient --}}
    <div id="addPatientModal"
        class="fixed inset-0 bg-blue-100/60 backdrop-blur-[3px] z-50 hidden flex justify-center items-center">
        <div
            class="bg-gradient-to-br from-blue-500 via-blue-400 to-blue-300 bg-opacity-90 rounded-2xl shadow-2xl w-full max-w-md p-8 relative border-2 border-blue-200">
            <!-- Close button -->
            <button onclick="togglePatientModal(false)"
                class="absolute top-3 right-3 text-white hover:text-blue-100 text-2xl font-bold">
                &times;
            </button>

            <h2 class="text-xl font-bold text-white mb-6 drop-shadow">Add New Patient</h2>

            <form method="POST" action="{{ route('admin.patients.store') }}" autocomplete="off">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-white drop-shadow">Name</label>
                    <input type="text" name="name" id="name" required autocomplete="off"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white drop-shadow">Email</label>
                    <input type="email" name="email" id="email" required autocomplete="off"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-white drop-shadow">Phone</label>
                    <input type="text" name="phone" id="phone"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-white drop-shadow">Address</label>
                    <input type="text" name="address" id="address"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>
                <div class="mb-4">
                    <label for="date_of_birth" class="block text-sm font-medium text-white drop-shadow">Date of
                        Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>
                <div class="mt-6 text-right">
                    <button type="submit"
                        class="bg-white bg-opacity-90 hover:bg-blue-600 hover:text-white text-blue-700 font-semibold py-2 px-6 rounded-lg shadow transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div id="confirmDeleteModal"
        class="fixed inset-0 bg-blue-100/60 backdrop-blur-[3px] z-50 hidden flex justify-center items-center">
        <div
            class="bg-gradient-to-br from-blue-500 via-blue-400 to-blue-300 bg-opacity-90 rounded-2xl shadow-2xl w-full max-w-sm p-8 relative border-2 border-blue-200">
            <button onclick="toggleDeleteModal(false)"
                class="absolute top-3 right-3 text-white hover:text-blue-100 text-2xl font-bold">&times;</button>
            <h2 class="text-xl font-bold text-white mb-6 drop-shadow text-center">Confirm Delete</h2>
            <p class="text-white text-center mb-8">Are you sure you want to delete this patient?</p>
            <div class="flex justify-center gap-4">
                <button type="button" onclick="toggleDeleteModal(false)"
                    class="bg-white bg-opacity-90 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-lg shadow transition">
                    Cancel
                </button>
                <form id="deletePatientForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-8">

        <!-- Heading -->
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-extrabold text-blue-600 tracking-tight">Patient Management</h2>
            <button id="addPatientButton"
                class="inline-flex items-center bg-blue-600 text-white px-5 py-2.5 rounded-xl shadow-md hover:bg-blue-700 transition duration-500 text-base font-semibold">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white mr-2">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="3"
                        viewBox="0 0 24 24">
                        {{-- <circle cx="12" cy="12" r="12" fill="white" /> --}}
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m4-4H8" />
                    </svg>
                </span>
                Add Patient
            </button>
        </div>

        <!-- Card Container -->
        <div
            class="bg-gradient-to-br from-blue-200 via-white to-blue-100 p-8 rounded-2xl shadow-2xl border-2 border-blue-300">

            <h3 class="text-2xl font-extrabold text-blue-800 mb-6 border-b-2 border-blue-300 pb-2">Registered
                Patients</h3>

            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-base font-semibold shadow-lg border border-blue-300 rounded-xl">
                    <thead class="bg-gradient-to-r from-blue-700 via-blue-500 to-blue-400 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left tracking-widest uppercase rounded-tl-xl">Name</th>
                            <th class="px-6 py-4 text-left tracking-widest uppercase">Email</th>
                            <th class="px-6 py-4 text-left tracking-widest uppercase">Phone</th>
                            <th class="px-6 py-4 text-left tracking-widest uppercase">Address</th>
                            <th class="px-6 py-4 text-left tracking-widest uppercase">Date of Birth</th>
                            <th class="px-6 py-4 text-center tracking-widest uppercase rounded-tr-xl">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $index => $patient)
                            <tr
                                class="{{ $index % 2 == 0 ? 'bg-blue-100/80' : 'bg-blue-50/80' }} hover:bg-blue-300/60 transition duration-200">
                                <td class="px-6 py-4 font-bold text-blue-900">{{ $patient->name }}</td>
                                <td class="px-6 py-4 text-blue-800">{{ $patient->email }}</td>
                                <td class="px-6 py-4 text-blue-800">{{ $patient->phone }}</td>
                                <td class="px-6 py-4 text-blue-800">{{ $patient->address }}</td>
                                <td class="px-6 py-4 text-blue-800">{{ $patient->date_of_birth }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="{{ route('admin.patients.toggle', $patient->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            class="{{ $patient->is_active ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 hover:bg-gray-500' }} text-white px-3 py-1 rounded shadow font-bold text-xs">
                                            {{ $patient->is_active ? 'Active' : 'Nonactive' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{-- <div class="mt-6">{{ $patients->links() }}</div> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#addPatientButton').on('click', function() {
                $('#addPatientModal input[type="text"]').val('');
                $('#addPatientModal input[type="email"]').val('');
                $('#addPatientModal input[type="date"]').val('');
                $('#addPatientModal').removeClass('hidden').addClass('flex');
            });

            window.togglePatientModal = function(show) {
                if (show) {
                    $('#addPatientModal input[type="text"]').val('');
                    $('#addPatientModal input[type="email"]').val('');
                    $('#addPatientModal input[type="date"]').val('');
                    $('#addPatientModal').removeClass('hidden').addClass('flex');
                } else {
                    $('#addPatientModal').removeClass('flex').addClass('hidden');
                }
            };

            window.showDeleteModal = function(id) {
                $('#deletePatientForm').attr('action', '/admin/patients/' + id);
                $('#confirmDeleteModal').removeClass('hidden').addClass('flex');
            };

            window.toggleDeleteModal = function(show) {
                if (show) {
                    $('#confirmDeleteModal').removeClass('hidden').addClass('flex');
                } else {
                    $('#confirmDeleteModal').removeClass('flex').addClass('hidden');
                }
            };
        });
    </script>
@endsection
