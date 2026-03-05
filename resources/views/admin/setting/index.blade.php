@extends('admin.layouts.app')

@section('content')
    <form id="app-settings-form" class="space-y-8 max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200">
        @csrf
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Update App Settings</h2>

        <!-- App Name -->
        <div class="flex flex-col space-y-2">
            <label for="app_name" class="text-sm font-medium text-gray-700">App Name</label>
            <input type="text" name="app_name" id="app_name" value="{{ $app_setting['app_name'] }}"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <!-- App Logo -->
        <div class="flex flex-col space-y-2">
            <label for="app_logo" class="text-sm font-medium text-gray-700">App Logo</label>
            <input type="file" name="app_logo" id="app_logo"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <img src="{{ $app_setting['app_logo'] }}" alt="Current Logo" class="mt-4 h-20 w-20 rounded-md border border-gray-300 shadow-sm">
        </div>

        <!-- App Description -->
        <div class="flex flex-col space-y-2">
            <label for="app_description" class="text-sm font-medium text-gray-700">App Description</label>
            <textarea name="app_description" id="app_description" rows="5"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $app_setting['app_description'] }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="button" id="update-settings"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Update Settings
            </button>
        </div>
    </form>
@endsection


@section('scripts')
    <script>
        $('#update-settings').click(function () {
            let formData = new FormData($('#app-settings-form')[0]);

            // Add CSRF token to the header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('admin.settings.update') }}", // Define this route in your routes/web.php
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Settings updated successfully!',
                        showConfirmButton: false,
                        timer: 1500, // Auto close after 1.5 second
                        timerProgressBar: true,
                    }).then(() => {
                        // reload the page
                        location.reload();
                    });
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON.message || 'An error occurred.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                    });
                }
            });
        });
    </script>
@endsection
