@extends('admin.layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Users Card -->
        <div
            class="bg-blue-50 rounded-2xl shadow-lg p-6 flex flex-col gap-2 border border-blue-200 hover:scale-105 transition">
            <div class="flex items-center gap-3">
                <div class="bg-blue-200 text-blue-700 rounded-full p-3">
                    <!-- Heroicon: User -->
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-blue-700">Users</span>
            </div>
            <div class="text-3xl font-extrabold text-blue-900">{{ $userCount }}</div>
            <div class="flex items-center gap-2">
                <span class="text-green-600 font-semibold text-sm">+{{ $newUsersThisMonth }} new</span>
            </div>
            <div class="text-xs text-gray-500">Registered users</div>
        </div>
        <!-- Performance Card -->
        <div
            class="bg-yellow-50 rounded-2xl shadow-lg p-6 flex flex-col gap-2 border border-yellow-200 hover:scale-105 transition">
            <div class="flex items-center gap-3">
                <div class="bg-yellow-200 text-yellow-700 rounded-full p-3">
                    <!-- Heroicon: TrendingUp -->
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 8-8" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-yellow-700">Consultations</span>
            </div>
            <div class="text-3xl font-extrabold text-yellow-900">{{ $performance ?? '-' }}</div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500">+{{ $performanceThisMonth ?? '-' }} successful consultations</span>
            </div>
            <div class="text-xs text-gray-500">This month</div>
        </div>
    </div>
@endsection
