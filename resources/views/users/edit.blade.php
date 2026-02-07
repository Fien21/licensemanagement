<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Edit User</title>

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Edit User</h2>
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
                        <h3 class="text-lg font-semibold text-gray-700">Update User Information</h3>
                    </div>

                    <form id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST" class="p-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- SEPARATED EMAIL AND RADIUS ID -->
                            <!-- PisoFi Email -->
                            <div>
                                <label for="email" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">PisoFi Email:</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}" 
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>

                            <!-- LPB Radius ID -->
                            <div>
                                <label for="radius_id" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">LPB Radius ID:</label>
                                <input type="text" name="radius_id" id="radius_id" value="{{ $user->radius_id }}" 
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>

                            <!-- Customer Name -->
                            <div>
                                <label for="customer_name" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Customer Name:</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ $user->customer_name }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Address:</label>
                                <input type="text" name="address" id="address" value="{{ $user->address }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>

                            <!-- Contact with 11-digit restriction -->
                            <div>
                                <label for="contact" class="block text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Primary Contact Number (11 Digits):</label>
                                <input type="text" name="contact" id="contact" value="{{ $user->contact }}" 
                                    maxlength="11"
                                    pattern="\d{11}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);"
                                    title="Please enter exactly 11 numeric digits."
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition-all bg-gray-50 hover:bg-white" required>
                            </div>
                        </div>

                        <div class="flex justify-end mt-10 pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition-all duration-200 shadow-lg font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update User Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Logic -->
    <script>
        // 1. Validation before submitting
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let form = this;
            let inputs = form.querySelectorAll('input[required]');
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
                    text: 'Please fill up all required fields before updating.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            // Contact length validation
            const contactInput = document.getElementById('contact');
            if (contactInput.value.length !== 11) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Contact',
                    text: 'The contact number must be exactly 11 digits.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            // Confirm submission
            Swal.fire({
                title: 'Save Changes?',
                text: "Are you sure you want to update this user's information?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while we save the user changes.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            });
        });

        // 2. Success Alert Handling
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = "{{ route('users.index') }}";
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444'
            });
        @endif
    </script>
</body>

</html>