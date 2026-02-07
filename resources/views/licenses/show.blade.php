<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - License Details</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>

<body class="antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Reusable Sidebar Component -->
        @include('sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Navbar -->
            <div class="bg-white shadow-sm border-b border-gray-200 m-4 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">License Details</h2>
                    </div>
                    <a href="{{ url()->previous() }}" class="inline-flex items-center bg-gray-800 text-white px-5 py-2.5 rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-x-auto p-4">
                <div class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 px-8 py-4">
                        <h3 class="text-lg font-semibold text-gray-700">Information Overview</h3>
                    </div>
                    
                    <div class="p-8">
                        <!-- Section 1: Core Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                            
                            <!-- Sheet Name -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all md:col-span-2 lg:col-span-1">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Branch Name</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->sheet_name }}</p>
                            </div>

                            <!-- License Key -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">License Key</p>
                                <p class="text-gray-900 font-mono font-semibold text-lg bg-gray-100 px-2 py-1 rounded inline-block">{{ $license->license }}</p>
                            </div>

                            <!-- Vendo Box No -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Vendo Box No.</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->vendo_box_no }}</p>
                            </div>

                            <!-- Device ID -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Device ID</p>
                                <p class="text-gray-900 font-mono text-sm bg-blue-50 text-blue-800 px-2 py-1 rounded inline-block">{{ $license->device_id }}</p>
                            </div>

                            <!-- Registration Date -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Registration Date</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->date }}</p>
                            </div>

                            <!-- Technician -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all lg:col-span-1">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Assigned Technician</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->technician }}</p>
                            </div>

                            <!-- Description -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all md:col-span-2 lg:col-span-2">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Description</p>
                                <p class="text-gray-700 leading-relaxed">{{ $license->description }}</p>
                            </div>
                        </div>

                        <!-- Section 2: Customer Information Container (Leaving blanks if data is missing) -->
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                            <h4 class="text-md font-bold text-gray-600 mb-6 border-b pb-2">Customer Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                
                                <!-- PisoFi Email -->
                                <div class="group">
                                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">PISOFI Email</p>
                                    <p class="text-gray-900 font-medium text-lg break-all">{{ $license->email }}</p>
                                </div>

                                <!-- LPB Radius ID -->
                                <div class="group">
                                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">LPB Radius ID</p>
                                    <p class="text-gray-900 font-mono font-medium text-lg">{{ $license->lpb_radius_id }}</p>
                                </div>

                                <!-- Customer Name -->
                                <div class="group">
                                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Customer Name</p>
                                    <p class="text-gray-900 font-medium text-lg">{{ $license->customer_name }}</p>
                                </div>

                                <!-- Contact Number -->
                                <div class="group">
                                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Contact Number</p>
                                    <p class="text-gray-900 font-medium text-lg">{{ $license->contact }}</p>
                                </div>

                                <!-- Address -->
                                <div class="group md:col-span-2">
                                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Address</p>
                                    <p class="text-gray-900 font-medium text-lg">{{ $license->address }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- History Log Section -->
                <div class="mt-8 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 px-8 py-4">
                        <h3 class="text-lg font-semibold text-gray-700">History Log</h3>
                    </div>

                    <div class="p-8">
                        <!-- Search and Sort Controls -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="relative">
                                <input type="text" id="history-search" class="w-full pl-10 pr-4 py-2 border rounded-lg" placeholder="Search history...">
                                <div class="absolute top-0 left-0 inline-flex items-center justify-center w-10 h-full text-gray-400">
                                    <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <select id="sort-year" class="border rounded-lg px-4 py-2">
                                    <option value="">All Years</option>
                                </select>
                                <select id="sort-month" class="border rounded-lg px-4 py-2">
                                    <option value="">All Months</option>
                                </select>
                                <select id="sort-day" class="border rounded-lg px-4 py-2">
                                    <option value="">All Days</option>
                                </select>
                            </div>
                        </div>

                        <!-- History Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                    </tr>
                                </thead>
                                <tbody id="history-log-body" class="bg-white divide-y divide-gray-200">
                                    @if($historyLogs->count() > 0)
                                        @foreach($historyLogs as $log)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $log->date }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $log->action }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $log->user }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $log->details }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-4">No history found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const historyLogBody = document.getElementById('history-log-body');
            const searchInput = document.getElementById('history-search');
            const yearSort = document.getElementById('sort-year');
            const monthSort = document.getElementById('sort-month');
            const daySort = document.getElementById('sort-day');

            const historyData = @json($historyLogs);

            function populateHistoryTable(data) {
                historyLogBody.innerHTML = '';
                if (data.length === 0) {
                    historyLogBody.innerHTML = '<tr><td colspan="4" class="text-center py-4">No history found.</td></tr>';
                    return;
                }
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">${item.date}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${item.action}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${item.user}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${item.details}</td>
                    `;
                    historyLogBody.appendChild(row);
                });
            }

            function populateSortOptions() {
                const years = [...new Set(historyData.map(item => new Date(item.date).getFullYear()))];
                years.sort().reverse().forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    yearSort.appendChild(option);
                });

                const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                months.forEach((month, index) => {
                    const option = document.createElement('option');
                    option.value = index + 1;
                    option.textContent = month;
                    monthSort.appendChild(option);
                });

                for (let i = 1; i <= 31; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    daySort.appendChild(option);
                }
            }

            function filterAndSortHistory() {
                let filteredData = [...historyData];

                const searchTerm = searchInput.value.toLowerCase();
                if (searchTerm) {
                    filteredData = filteredData.filter(item =>
                        Object.values(item).some(val =>
                            val.toString().toLowerCase().includes(searchTerm)
                        )
                    );
                }

                const year = yearSort.value;
                if (year) {
                    filteredData = filteredData.filter(item => new Date(item.date).getFullYear() == year);
                }

                const month = monthSort.value;
                if (month) {
                    filteredData = filteredData.filter(item => new Date(item.date).getMonth() + 1 == month);
                }

                const day = daySort.value;
                if (day) {
                    filteredData = filteredData.filter(item => new Date(item.date).getDate() == day);
                }

                populateHistoryTable(filteredData);
            }

            // Initial population
            populateHistoryTable(historyData);
            populateSortOptions();

            // Event Listeners
            searchInput.addEventListener('input', filterAndSortHistory);
            yearSort.addEventListener('change', filterAndSortHistory);
            monthSort.addEventListener('change', filterAndSortHistory);
            daySort.addEventListener('change', filterAndSortHistory);
        });
    </script>
</body>

</html>