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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="id-card" />
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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <!-- Sheet Name -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Sheet Name</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->sheet_name }}</p>
                            </div>

                            <!-- Vendo Machine -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Vendo Machine</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->vendo_machine }}</p>
                            </div>

                            <!-- License -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">License Key</p>
                                <p class="text-gray-900 font-mono font-semibold text-lg bg-gray-100 px-2 py-1 rounded inline-block">{{ $license->license }}</p>
                            </div>

                            <!-- Customer Name -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Customer Name</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->customer_name }}</p>
                            </div>

                            <!-- Email -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Email Address</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->email }}</p>
                            </div>

                            <!-- Address -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Address</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->address }}</p>
                            </div>

                            <!-- Contact -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Contact Number</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->contact }}</p>
                            </div>

                            <!-- Date -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Registration Date</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->date }}</p>
                            </div>

                            <!-- Technician -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Assigned Technician</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->technician }}</p>
                            </div>

                            <!-- Device ID -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Device ID</p>
                                <p class="text-gray-900 font-mono text-sm bg-blue-50 text-blue-800 px-2 py-1 rounded inline-block">{{ $license->device_id }}</p>
                            </div>

                            <!-- Vendo Box No -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Vendo Box No.</p>
                                <p class="text-gray-900 font-medium text-lg">{{ $license->vendo_box_no }}</p>
                            </div>

                            <!-- Description -->
                            <div class="group p-4 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 transition-all lg:col-span-2">
                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1">Description</p>
                                <p class="text-gray-700 leading-relaxed">{{ $license->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>