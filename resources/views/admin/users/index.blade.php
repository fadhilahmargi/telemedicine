@extends('admin.layouts.app')

@section('content')
    {{-- modal add user --}}
    <div id="addUserModal" class="fixed inset-0 bg-opacity-30 backdrop-blur-sm z-50 hidden flex justify-center items-center">
        <div
            class="bg-gradient-to-br from-blue-500 via-blue-400 to-blue-300 bg-opacity-90 rounded-2xl shadow-2xl w-full max-w-md p-8 relative border-2 border-blue-200">
            <!-- Close button -->
            <button onclick="toggleModal(false)"
                class="absolute top-3 right-3 text-white hover:text-blue-100 text-2xl font-bold">
                &times;
            </button>

            <h2 class="text-xl font-bold text-white mb-6 drop-shadow">Add New User</h2>

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-white drop-shadow">Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full mt-1 px-4 py-2 border border-blue-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white bg-opacity-80">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-white drop-shadow">Email</label>
                    <input type="email" name="email" id="email" required
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
        class="fixed inset-0 bg-opacity-30 backdrop-blur-sm z-50 hidden flex justify-center items-center">
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
                                        class="inline-block px-3 py-1 text-xs font-bold rounded-full text-center
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
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow font-bold">Delete</button>
                                    </form>
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
                $('#addUserModal').removeClass('hidden').addClass('flex');
            });

            window.toggleModal = function(show) {
                if (show) {
                    $('#addUserModal').removeClass('hidden').addClass('flex');
                } else {
                    $('#addUserModal').removeClass('flex').addClass('hidden');
                }
            };
            // Tambahkan script ini
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
        });
    </script>
@endsection
