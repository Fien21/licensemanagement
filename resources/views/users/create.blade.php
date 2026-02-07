<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Add User</title>

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Add New User</h2>
                    </div>
                    <a href="{{ route('users.index') }}" class="inline-flex items-center bg-gray-800 text-white px-5 py-2.5 rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm font-medium">
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
                        <h3 class="text-lg font-semibold text-gray-700">User Account Information</h3>
                    </div>

                    <form id="addUserForm" action="{{ route('users.store') }}" method="POST" class="p-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">PisoFi Email / LPB Radius ID:</label>
                                <input type="email" name="email" id="email" placeholder="example@email.com" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>

                            <!-- Customer Name -->
                            <div>
                                <label for="customer_name" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Customer Name:</label>
                                <input type="text" name="customer_name" id="customer_name" placeholder="Enter full name" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Address:</label>
                                <input type="text" name="address" id="address" placeholder="Enter complete address" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>

                            <!-- Contact -->
                            <div>
                                <label for="contact" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Contact:</label>
                                <input type="text" name="contact" id="contact" placeholder="Phone number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Password:</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>
                        </div>

                        <div class="flex justify-end mt-10 pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition-all duration-200 shadow-lg font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. Validation before submitting
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let form = this;
            let inputs = form.querySelectorAll('input[required]');
            let isEmpty = false;

            inputs.forEach(input => {
                if (input.value.trim() === "") {
                    isEmpty = true;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (isEmpty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Incomplete Form',
                    text: 'Please fill out all required fields.',
                    confirmButtonColor: '#4f46e5'
                });
            } else {
                // Show loading and submit
                Swal.fire({
                    title: 'Creating Account...',
                    text: 'Please wait while we set up the new user.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });

        // 2. Success Alert (Triggers if session('success') exists)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'User Created!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
</body>

</html>