@extends('admin.layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Users</h2>
            <p class="mt-2 text-gray-500">102 registered users</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Revenue</h2>
            <p class="mt-2 text-gray-500">$2,340 this month</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Performance</h2>
            <p class="mt-2 text-gray-500">87% increase</p>
        </div>
    </div>
@endsection
