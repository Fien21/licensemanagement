<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel - User Manager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Reusable Sidebar Component -->
        @include('sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- SweetAlert Flash Messages for Session Success/Error -->
            @if (session('success'))
                <script>
                    window.onload = function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "{{ session('success') }}",
                            confirmButtonColor: '#10b981'
                        });
                    };
                </script>
            @endif

            @if (session('error'))
                <script>
                    window.onload = function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: "{{ session('error') }}",
                            confirmButtonColor: '#ef4444'
                        });
                    };
                </script>
            @endif
            
            <!-- Navbar / Header Area -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Manage Users</h2>
                    </div>
                    <div class="flex items-center">
                        <button id="add-user-button" class="ml-4 bg-green-600 text-white px-8 py-3 rounded-xl hover:bg-green-700 transition-all duration-300 ease-in-out shadow-lg font-bold text-lg">
                            + Add New User
                        </button>
                    </div>
                </div>
            </div>

            <!-- Search and Filters Section -->
            <div class="bg-white shadow-md rounded-lg m-4 p-8">
                <form action="/users" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Search Records</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                class="mt-1 block w-full rounded-xl border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg p-4" 
                                placeholder="Search for name, email, radius ID, address or contact details...">
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-10 py-3 rounded-xl hover:bg-blue-700 transition-all duration-300 ease-in-out shadow-lg font-bold">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Main Content Table -->
            <div class="flex-1 overflow-x-auto p-4">
                <div class="bg-white rounded-xl shadow-xl p-8 border border-gray-100">
                    
                    <!-- Bulk Action Form wraps only the Archive button and Checkboxes -->
                    <form id="bulk-form" action="{{ route('users.bulkArchive') }}" method="POST">
                        @csrf
                        <div class="flex items-center justify-between mb-6">
                            <button type="submit" id="bulk-archive-btn" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-all duration-300 ease-in-out shadow-md font-semibold">
                                Archive Selected
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full bg-white text-base">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-4 text-left rounded-tl-lg"><input type="checkbox" id="select-all" class="w-5 h-5 rounded accent-blue-500"></th>
                                        <!-- SEPARATED COLUMNS -->
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">PisoFi Email</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">LPB Radius ID</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">Customer Name</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">Address</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">Contact</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($users as $user)
                                    <tr class="hover:bg-blue-50 transition-colors">
                                        <td class="p-4"><input type="checkbox" name="ids[]" value="{{ $user->id }}" class="user-checkbox w-5 h-5 rounded accent-blue-500"></td>
                                        <td class="p-4 font-medium text-gray-700">{{ $user->email }}</td>
                                        <td class="p-4 font-medium text-gray-700">{{ $user->radius_id }}</td>
                                        <td class="p-4 font-bold text-gray-900">{{ $user->customer_name }}</td>
                                        <td class="p-4 text-gray-600">{{ $user->address }}</td>
                                        <td class="p-4 text-gray-600">{{ $user->contact }}</td>
                                        <td class="p-4 flex items-center space-x-4">
                                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-bold underline decoration-2 underline-offset-4">Edit</a>
                                            
                                            <!-- INDIVIDUAL ARCHIVE BUTTON (Independent of checkboxes) -->
                                            <button type="button" 
                                                    data-id="{{ $user->id }}" 
                                                    data-action="{{ route('users.archive', $user->id) }}"
                                                    class="text-red-500 hover:text-red-700 font-bold underline decoration-2 underline-offset-4 individual-archive-btn">
                                                Archive
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($users->isEmpty())
                                <div class="text-center py-10">
                                    <p class="text-gray-500 text-xl italic">No users found matching your criteria.</p>
                                </div>
                            @endif
                        </div>
                    </form>

                    <!-- Hidden Single Archive Form to maintain valid HTML and independent logic -->
                    <form id="single-archive-form" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Add User Modal -->
    <div id="add-user-modal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100">
                
                <div class="bg-gray-50 px-8 py-6 border-b border-gray-200">
                    <h3 class="text-2xl font-extrabold text-gray-800" id="modal-title">
                        Add New User Profile
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Fill out the form below to register a new customer in the system.</p>
                </div>

                <form id="add-user-form" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-8 py-10">
                        <div class="space-y-6">
                            
                            <!-- SEPARATED EMAIL AND RADIUS ID IN MODAL -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="email" class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">PisoFi Email</label>
                                    <input type="email" name="email" id="email" required
                                        class="block w-full px-5 py-4 rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 text-lg transition-all shadow-sm" 
                                        placeholder="customer@domain.com">
                                </div>
                                <div>
                                    <label for="radius_id" class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">LPB Radius ID</label>
                                    <input type="text" name="radius_id" id="radius_id" required
                                        class="block w-full px-5 py-4 rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 text-lg transition-all shadow-sm" 
                                        placeholder="e.g., LPB-12345">
                                </div>
                            </div>

                            <div>
                                <label for="customer_name" class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">Full Customer Name</label>
                                <input type="text" name="customer_name" id="customer_name" required
                                    class="block w-full px-5 py-4 rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 text-lg transition-all shadow-sm" 
                                    placeholder="e.g., Juan Dela Cruz">
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">Complete Address</label>
                                <input type="text" name="address" id="address" required
                                    class="block w-full px-5 py-4 rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 text-lg transition-all shadow-sm" 
                                    placeholder="Street, Barangay, City, Province">
                            </div>

                            <!-- CONTACT NUMBER WITH 11 DIGIT ONLY RESTRICTION -->
                            <div>
                                <label for="contact" class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">Primary Contact Number</label>
                                <input type="text" name="contact" id="contact" required
                                    maxlength="11"
                                    pattern="\d{11}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);"
                                    title="Contact number must be exactly 11 digits."
                                    class="block w-full px-5 py-4 rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 text-lg transition-all shadow-sm" 
                                    placeholder="e.g., 09123456789">
                            </div>

                        </div>
                    </div>

                    <div class="bg-gray-50 px-8 py-6 sm:flex sm:flex-row-reverse border-t border-gray-200 gap-4">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg px-8 py-3 bg-green-600 text-lg font-bold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto transition-all duration-200">
                            Save User Record
                        </button>
                        <button type="button" id="cancel-add-user" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-8 py-3 bg-white text-lg font-bold text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto transition-all duration-200">
                            Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Logic -->
    <script>
        // 1. Select All Checkboxes Logic
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.user-checkbox');
        if(selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });
        }

        // 2. Add User Modal Visibility Toggle
        const addUserButton = document.getElementById('add-user-button');
        const addUserModal = document.getElementById('add-user-modal');
        const cancelAddUserButton = document.getElementById('cancel-add-user');

        addUserButton.addEventListener('click', () => {
            addUserModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        cancelAddUserButton.addEventListener('click', () => {
            addUserModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        // 3. Form Submission Confirmation (Adding User)
        const addUserForm = document.getElementById('add-user-form');
        addUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Final check for 11 digits
            const contactInput = document.getElementById('contact');
            if(contactInput.value.length !== 11) {
                Swal.fire('Error', 'Contact number must be exactly 11 digits.', 'error');
                return;
            }

            Swal.fire({
                title: 'Confirm New Entry?',
                text: "Are you sure you want to add this user information?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // 4. INDIVIDUAL ARCHIVE INDEPENDENT LOGIC
        // This targets the specific row only, ignoring bulk checkboxes
        document.querySelectorAll('.individual-archive-btn').forEach(button => {
            button.addEventListener('click', function() {
                const actionUrl = this.getAttribute('data-action');
                const singleForm = document.getElementById('single-archive-form');
                
                Swal.fire({
                    title: 'Move to Archive?',
                    text: "This specific user will be archived. No selection check needed.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Archive User'
                }).then((result) => {
                    if (result.isConfirmed) {
                        singleForm.action = actionUrl;
                        singleForm.submit();
                    }
                });
            });
        });

        // 5. Bulk Archive Logic & Selection Validation
        const bulkForm = document.getElementById('bulk-form');
        bulkForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedIds = document.querySelectorAll('.user-checkbox:checked');
            
            if (selectedIds.length === 0) {
                Swal.fire({
                    title: 'No Items Selected',
                    text: 'To use Bulk Archive, please select at least one user by checking the box.',
                    icon: 'info',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            Swal.fire({
                title: 'Archive Multiple?',
                text: `You are about to archive ${selectedIds.length} selected user(s). Proceed?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Archive Selected'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
</body>
</html>