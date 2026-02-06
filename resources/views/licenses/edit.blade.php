<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Edit License</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Edit License</h2>
                    </div>
                    <a href="{{ $license->trashed() ? route('archived') : route('licenses.index') }}" class="inline-flex items-center bg-gray-800 text-white px-5 py-2.5 rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm font-medium">
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
                        <h3 class="text-lg font-semibold text-gray-700">Update License Information</h3>
                    </div>

                    <form id="editLicenseForm" action="{{ route('licenses.update', $license->id) }}" method="POST" class="p-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Sheet Name -->
                            <div>
                                <label for="sheet_name" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Sheet Name:</label>
                                <input type="text" name="sheet_name" id="sheet_name" value="{{ $license->sheet_name }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- Vendo Machine -->
                            <div>
                                <label for="vendo_machine" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Vendo Machine:</label>
                                <input type="text" name="vendo_machine" id="vendo_machine" value="{{ $license->vendo_machine }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- License -->
                            <div>
                                <label for="license" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">License:</label>
                                <input type="text" name="license" id="license" value="{{ $license->license }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white font-mono">
                            </div>

                            <!-- Customer Name -->
                            <div>
                                <label for="customer_name" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Customer Name:</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ $license->customer_name }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Email:</label>
                                <input type="email" name="email" id="email" value="{{ $license->email }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Address:</label>
                                <input type="text" name="address" id="address" value="{{ $license->address }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- Contact -->
                            <div>
                                <label for="contact" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Contact:</label>
                                <input type="text" name="contact" id="contact" value="{{ $license->contact }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Date:</label>
                                <input type="date" name="date" id="date" value="{{ $license->date }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- Technician -->
                            <div>
                                <label for="technician" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Technician:</label>
                                <input type="text" name="technician" id="technician" value="{{ $license->technician }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- Device ID -->
                            <div>
                                <label for="device_id" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Device ID:</label>
                                <input type="text" name="device_id" id="device_id" value="{{ $license->device_id }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white font-mono">
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Description:</label>
                                <input type="text" name="description" id="description" value="{{ $license->description }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>

                            <!-- Vendo Box No -->
                            <div>
                                <label for="vendo_box_no" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Vendo Box No:</label>
                                <input type="text" name="vendo_box_no" id="vendo_box_no" value="{{ $license->vendo_box_no }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white">
                            </div>
                        </div>

                        <div class="flex justify-end mt-10 pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition-all duration-200 shadow-lg font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update License
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. Validation before submitting
        document.getElementById('editLicenseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let form = this;
            let inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="date"]');
            let isEmpty = false;

            inputs.forEach(input => {
                if (input.value.trim() === "") {
                    isEmpty = true;
                }
            });

            if (isEmpty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Information',
                    text: 'Please fill up all fields before updating.',
                    confirmButtonColor: '#4f46e5'
                });
            } else {
                // Show loading and submit
                Swal.fire({
                    title: 'Updating...',
                    text: 'Please wait while we save the changes.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });

        // 2. Success Alert (This will trigger after redirecting to the index if you have session('success'))
        // Note: Place this logic in your index.blade.php as well to see the alert there
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = "{{ $license->trashed() ? route('archived') : route('licenses.index') }}";
            });
        @endif
    </script>
</body>

</html>
