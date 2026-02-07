<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Archived Users</title>

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

            <!-- Session Messages (SweetAlert) -->
            @if (session('success'))
                <script>
                    window.onload = () => {
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
                    window.onload = () => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: "{{ session('error') }}",
                            confirmButtonColor: '#ef4444'
                        });
                    };
                </script>
            @endif

            <!-- Header -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Archived Users</h2>
                </div>
            </div>

            <!-- Content Table Area -->
            <div class="flex-1 overflow-x-auto p-4">
                <div class="bg-white rounded-xl shadow-xl p-8 border border-gray-100">
                    
                    <!-- Bulk Action Form -->
                    <form id="bulk-form" method="POST">
                        @csrf
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex space-x-4">
                                <button type="button" id="bulk-restore-btn" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 shadow-md font-semibold transition-all">
                                    Restore Selected
                                </button>
                                <button type="button" id="bulk-delete-btn" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 shadow-md font-semibold transition-all">
                                    Delete Selected Permanently
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full bg-white text-base">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-4 text-left rounded-tl-lg">
                                            <input type="checkbox" id="select-all" class="w-5 h-5 rounded accent-blue-500">
                                        </th>
                                        <!-- SEPARATED COLUMNS FOR EMAIL AND RADIUS ID -->
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">PisoFi Email</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">LPB Radius ID</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">Customer Name</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">Address</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider">Contact</th>
                                        <th class="p-4 text-left font-semibold uppercase text-sm tracking-wider rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($users as $user)
                                    <tr class="hover:bg-blue-50 transition-colors">
                                        <td class="p-4">
                                            <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="user-checkbox w-5 h-5 rounded accent-blue-500">
                                        </td>
                                        <td class="p-4 font-medium text-gray-700">{{ $user->email }}</td>
                                        <td class="p-4 font-medium text-gray-700">{{ $user->radius_id }}</td>
                                        <td class="p-4 font-bold text-gray-900">{{ $user->customer_name }}</td>
                                        <td class="p-4 text-gray-600">{{ $user->address }}</td>
                                        <td class="p-4 text-gray-600">{{ $user->contact }}</td>
                                        <td class="p-4 flex items-center space-x-4">
                                            <!-- INDIVIDUAL RESTORE BUTTON -->
                                            <button type="button" 
                                                data-action="/users/archived/{{ $user->id }}/restore" 
                                                class="text-blue-600 hover:text-blue-900 font-bold underline decoration-2 underline-offset-4 individual-restore-btn">
                                                Restore
                                            </button>

                                            <!-- INDIVIDUAL DELETE BUTTON -->
                                            <button type="button" 
                                                data-action="/users/archived/{{ $user->id }}/delete" 
                                                class="text-red-500 hover:text-red-700 font-bold underline decoration-2 underline-offset-4 individual-delete-btn">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-10">
                                            <p class="text-gray-500 text-xl italic">The archive is currently empty.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Hidden Form for Individual Actions (Prevents form-nesting issues) -->
                    <form id="individual-action-form" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Logic -->
    <script>
        // 1. Select All Checkboxes
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.user-checkbox');
        
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });
        }

        // 2. Individual Action Confirmation (Restore)
        document.querySelectorAll('.individual-restore-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const actionUrl = this.getAttribute('data-action');
                const singleForm = document.getElementById('individual-action-form');
                
                Swal.fire({ 
                    title: 'Restore User?', 
                    text: "This user will be moved back to the active list immediately.", 
                    icon: 'question', 
                    showCancelButton: true, 
                    confirmButtonColor: '#3b82f6',
                    confirmButtonText: 'Yes, Restore User' 
                }).then(result => {
                    if (result.isConfirmed) {
                        singleForm.action = actionUrl;
                        singleForm.submit();
                    }
                });
            });
        });

        // 3. Individual Action Confirmation (Permanent Delete)
        document.querySelectorAll('.individual-delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const actionUrl = this.getAttribute('data-action');
                const singleForm = document.getElementById('individual-action-form');
                
                Swal.fire({ 
                    title: 'Delete Permanently?', 
                    text: "This action cannot be undone. The user record will be gone forever.", 
                    icon: 'warning', 
                    showCancelButton: true, 
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Yes, Delete Forever' 
                }).then(result => {
                    if (result.isConfirmed) {
                        singleForm.action = actionUrl;
                        singleForm.submit();
                    }
                });
            });
        });
        
        // 4. Bulk Action Logic
        const bulkForm = document.getElementById('bulk-form');
        const bulkRestoreBtn = document.getElementById('bulk-restore-btn');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

        const getSelectedCount = () => document.querySelectorAll('.user-checkbox:checked').length;

        // Bulk Restore
        bulkRestoreBtn.addEventListener('click', () => {
            const count = getSelectedCount();
            if(count === 0) return Swal.fire('No selection', 'Please select at least one user to restore.', 'info');
            
            Swal.fire({ 
                title: `Restore ${count} Users?`, 
                text: 'All selected users will be moved back to the active list.',
                icon: 'question', 
                showCancelButton: true, 
                confirmButtonColor: '#3b82f6',
                confirmButtonText: 'Yes, Restore All Selected' 
            }).then(result => {
                if(result.isConfirmed) {
                    bulkForm.action = "{{ route('users.bulkRestore') }}";
                    bulkForm.submit();
                }
            });
        });

        // Bulk Delete
        bulkDeleteBtn.addEventListener('click', () => {
            const count = getSelectedCount();
            if(count === 0) return Swal.fire('No selection', 'Please select at least one user to delete.', 'info');
            
            Swal.fire({ 
                title: `Permanently delete ${count} users?`, 
                text: 'This action is destructive and cannot be undone.', 
                icon: 'error', 
                showCancelButton: true, 
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Delete Selected Forever' 
            }).then(result => {
                if(result.isConfirmed) {
                    bulkForm.action = "{{ route('users.bulkDelete') }}";
                    bulkForm.submit();
                }
            });
        });

    </script>
</body>
</html>