@extends('layouts.app')

@section('content')
    <!-- Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="text-gray-500 text-sm">Total Students</h3>
                    <p class="text-3xl font-semibold text-indigo-600 mt-2">1,240</p>
                    <p class="text-sm text-gray-400 mt-1">Active: 1,200 | Inactive: 40</p>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="text-gray-500 text-sm">Monthly Fee Collection</h3>
                    <p class="text-3xl font-semibold text-green-600 mt-2">MMK 8,500,000</p>
                    <p class="text-sm text-gray-400 mt-1">Compared to last month: +5%</p>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="text-gray-500 text-sm">Book Stock</h3>
                    <p class="text-3xl font-semibold text-blue-600 mt-2">320</p>
                    <p class="text-sm text-gray-400 mt-1">20 low-stock items</p>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="text-gray-500 text-sm">Total Expenses</h3>
                    <p class="text-3xl font-semibold text-red-600 mt-2">MMK 2,100,000</p>
                    <p class="text-sm text-gray-400 mt-1">This month</p>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="mt-10 bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Reports Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 mb-2">Fee Collection Trend</p>
                        <div class="h-40 bg-gray-100 rounded-md flex items-center justify-center text-gray-400">[Chart]</div>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-2">Expense Overview</p>
                        <div class="h-40 bg-gray-100 rounded-md flex items-center justify-center text-gray-400">[Chart]</div>
                    </div>
                </div>
            </div>
@endsection