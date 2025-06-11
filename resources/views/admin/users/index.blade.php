@extends('admin.layouts.app')

@section('content')
    {{-- modal add user --}}
    <div id="addUserModal"
        class="fixed inset-0 bg-blue-100/60 backdrop-blur-[3px] z-50 hidden flex justify-center items-center">
        <div
            class="bg-gradient-to-br from-blue-500 via-blue-400 to-blue-300 bg-opacity-90 rounded-2xl shadow-2xl w-full max-w-md p-8 relative border-2 border-blue-200">
            <!-- Close button -->
            <button onclick="toggleModal(false)"
                class="absolute top-3 right-3 text-white hover:text-blue-100 text-2xl font-bold">
                &times;
            </button>

            <h2 class="text-xl font-bold text-white mb-6 drop-shadow">Add New User</h2>

            <form method="POST" action="{{ route('admin.users.store') }}" autocomplete="off">
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
                    <label for="password" class="block text-sm font-medium text-white drop-shadow">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-white drop-shadow">Role</label>
                    <select name="role" id="role"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                        <option value="spesialis">Spesialis</option>
                        <option value="penjaga">Penjaga</option>
                    </select>
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

    {{-- Modal Edit User --}}
    <div id="editUserModal"
        class="fixed inset-0 bg-blue-100/60 backdrop-blur-[3px] z-50 hidden flex justify-center items-center">
        <div
            class="bg-gradient-to-br from-blue-500 via-blue-400 to-blue-300 bg-opacity-90 rounded-2xl shadow-2xl w-full max-w-md p-8 relative border-2 border-blue-200">
            <!-- Close button -->
            <button onclick="toggleEditModal(false)"
                class="absolute top-3 right-3 text-white hover:text-blue-100 text-2xl font-bold">
                &times;
            </button>
            <h2 class="text-xl font-bold text-white mb-6 drop-shadow">Edit User</h2>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-medium text-white drop-shadow">Name</label>
                    <input type="text" name="name" id="edit_name" required
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>
                <div class="mb-4">
                    <label for="edit_email" class="block text-sm font-medium text-white drop-shadow">Email</label>
                    <input type="email" name="email" id="edit_email" required
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>
                <div class="mb-4">
                    <label for="edit_password" class="block text-sm font-medium text-white drop-shadow">Password (Kosongkan
                        jika tidak diubah)</label>
                    <input type="password" name="password" id="edit_password" autocomplete="off"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>
                <div class="mb-4">
                    <label for="edit_role" class="block text-sm font-medium text-white drop-shadow">Role</label>
                    <select name="role" id="edit_role"
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                        <option value="spesialis">Spesialis</option>
                        <option value="penjaga">Penjaga</option>
                    </select>
                </div>
                <div class="mt-6 text-right">
                    <button type="submit"
                        class="bg-white bg-opacity-90 hover:bg-blue-600 hover:text-white text-blue-700 font-semibold py-2 px-6 rounded-lg shadow transition">
                        Update
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
            <h2 class="text-xl font-bold text-white mb-6 drop-shadow text-center">Konfirmasi Hapus</h2>
            <p class="text-white text-center mb-8">Yakin ingin menghapus user ini?</p>
            <div class="flex justify-center gap-4">
                <button type="button" onclick="toggleDeleteModal(false)"
                    class="bg-white bg-opacity-90 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-lg shadow transition">
                    Batal
                </button>
                <form id="deleteUserForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-8">

        <!-- Heading -->
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-extrabold text-blue-600 tracking-tight">User Management</h2>
            <button id="addUserButton"
                class="inline-block bg-blue-600 text-white px-5 py-2.5 rounded-xl shadow-md hover:bg-blue-700 transition duration-300 text-sm font-semibold">
                + Add User
            </button>
        </div>

        <!-- Card Container -->
        <div
            class="bg-gradient-to-br from-blue-200 via-white to-blue-100 p-8 rounded-2xl shadow-2xl border-2 border-blue-300">

            <h3 class="text-2xl font-extrabold text-blue-800 mb-6 border-b-2 border-blue-300 pb-2">Registered
                Users</h3>

            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-base font-semibold shadow-lg border border-blue-300 rounded-xl">
                    <thead class="bg-gradient-to-r from-blue-700 via-blue-500 to-blue-400 text-white">
                        <th class="px-6 py-4 text-left tracking-widest uppercase rounded-tl-xl">Name</th>
                        <th class="px-6 py-4 text-left tracking-widest uppercase">Email</th>
                        <th class="px-6 py-4 text-center tracking-widest uppercase">Role</th>
                        <th class="px-6 py-4 text-center tracking-widest uppercase rounded-tr-xl">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr
                                class="{{ $index % 2 == 0 ? 'bg-blue-100/80' : 'bg-blue-50/80' }} hover:bg-blue-300/60 transition duration-200">
                                <td class="px-6 py-4 font-bold text-blue-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-blue-800">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-block px-3 py-2 text-xs font-bold rounded-full text-center
                                            @if ($user->role === 'penjaga') bg-blue-400 text-white
                                            @elseif ($user->role === 'spesialis')
                                                bg-blue-800 text-white
                                            @else
                                                bg-gray-300 text-gray-700 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="javascript:void(0);"
                                        onclick="showEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow font-bold mr-2">
                                        Edit
                                    </a>
                                    <button type="button" onclick="showDeleteModal({{ $user->id }})"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow font-bold">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{-- <div class="mt-6">{{ $users->links() }}</div> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#addUserButton').on('click', function() {
                // Kosongkan semua input dan select di modal Add User
                $('#addUserModal input[type="text"]').val('');
                $('#addUserModal input[type="email"]').val('');
                $('#addUserModal input[type="password"]').val('');
                $('#addUserModal select').prop('selectedIndex', 0);
                $('#addUserModal').removeClass('hidden').addClass('flex');
            });

            window.toggleModal = function(show) {
                if (show) {
                    // Kosongkan semua input dan select di modal Add User
                    $('#addUserModal input[type="text"]').val('');
                    $('#addUserModal input[type="email"]').val('');
                    $('#addUserModal input[type="password"]').val('');
                    $('#addUserModal select').prop('selectedIndex', 0);
                    $('#addUserModal').removeClass('hidden').addClass('flex');
                } else {
                    $('#addUserModal').removeClass('flex').addClass('hidden');
                }
            };

            window.toggleEditModal = function(show) {
                if (show) {
                    $('#editUserModal').removeClass('hidden').addClass('flex');
                } else {
                    $('#editUserModal').removeClass('flex').addClass('hidden');
                }
            };

            window.showEditModal = function(id, name, email, role) {
                $('#editUserForm').attr('action', '/admin/users/' + id);
                $('#edit_name').val(name);
                $('#edit_email').val(email);
                $('#edit_role').val(role);
                $('#edit_password').val('');
                toggleEditModal(true);
            };

            window.showDeleteModal = function(id) {
                $('#deleteUserForm').attr('action', '/admin/users/' + id);
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
{{-- @section('scripts')
    <script>
        $(document).ready(function() {
            $('#addUserButton').on('click', function() {
                $('#addUserModal').removeClass('hidden').addClass('flex');
            });

            window.toggleModal = function(show) {
                if (show) {
                    $('#addUserModal').removeClass('hidden').addClass('flex');
                } else {
                    $('#addUserModal').removeClass('flex').addClass('hidden');
                }
            };
            window.toggleEditModal = function(show) {
                if (show) {
                    $('#editUserModal').removeClass('hidden').addClass('flex');
                } else {
                    $('#editUserModal').removeClass('flex').addClass('hidden');
                }
            };

            window.showEditModal = function(id, name, email, role) {
                $('#editUserForm').attr('action', '/admin/users/' + id);
                $('#edit_name').val(name);
                $('#edit_email').val(email);
                $('#edit_role').val(role);
                toggleEditModal(true);
            };
            window.showDeleteModal = function(id) {
                $('#deleteUserForm').attr('action', '/admin/users/' + id);
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
@endsection --}}
