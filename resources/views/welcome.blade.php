
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-4">
                <h1 class="text-2xl font-bold">License Manager</h1>
            </div>
            <nav class="mt-4">
                <a href="/" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg m-2">Dashboard</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg m-2">Licenses</a>
                <a href="/licenses/archived" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg m-2">Archived</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg m-2">Settings</a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            @if (session('success'))
                <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <!-- Navbar -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <h2 class="text-3xl font-bold text-gray-800">Manage Licenses</h2>
                        <span class="ml-4 bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Total: {{ $totalLicenses }}</span>
                    </div>
                    <div class="flex items-center">
                        <div class="relative inline-block text-left mr-4">
                            <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" id="bulk-actions-menu" aria-haspopup="true" aria-expanded="true">
                                Bulk Actions
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="bulk-actions-dropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="bulk-actions-menu">
                                    <a href="#" id="bulk-archive" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Archive Selected</a>
                                    <a href="#" id="bulk-delete" class="block px-4 py-2 text-sm text-red-700 hover:bg-gray-100" role="menuitem">Delete Selected</a>
                                </div>
                            </div>
                        </div>
                        <button id="batch-upload-button" class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition-colors duration-300 ease-in-out shadow-lg">Batch Upload</button>
                        <button id="add-license-button" class="ml-4 bg-green-500 text-white px-6 py-2 rounded-full hover:bg-green-600 transition-colors duration-300 ease-in-out shadow-lg">+ Add New License</button>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-600">This page lists all active licenses in the system. You can add new licenses, edit existing ones, or move them to the archive.</p>
                </div>
            </div>


            <!-- Search and Filters -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <form action="/" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Search for anything...">
                        </div>
                        <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700">Sort By</label>
                            <select id="sort_by" name="sort_by" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest Registered</option>
                                <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Oldest Registered</option>
                                <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                <option value="modified_newest" {{ request('sort_by') == 'modified_newest' ? 'selected' : '' }}>Last Modified (Newest)</option>
                                <option value="modified_oldest" {{ request('sort_by') == 'modified_oldest' ? 'selected' : '' }}>Last Modified (Oldest)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition-colors duration-300 ease-in-out shadow-lg">Apply Filters</button>
                    </div>
                </form>
            </div>


            <!-- Content -->
            <div class="flex-1 overflow-x-auto p-4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <form id="bulk-form" method="POST">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="w-full bg-white text-sm">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-2 text-left"><input type="checkbox" id="select-all"></th>
                                        <th class="p-2 text-left">Vendo Box No.</th>
                                        <th class="p-2 text-left">Vendo Machine</th>
                                        <th class="p-2 text-left">License</th>
                                        <th class="p-2 text-left">Device ID</th>
                                        <th class="p-2 text-left">Description</th>
                                        <th class="p-2 text-left">Date</th>
                                        <th class="p-2 text-left">Technician</th>
                                        <th class="p-2 text-left">PisoFi Email / LPB Radius ID</th>
                                        <th class="p-2 text-left">Customer Name</th>
                                        <th class="p-2 text-left">Address</th>
                                        <th class="p-2 text-left">Contact</th>
                                        <th class="p-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($licenses as $license)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="p-2"><input type="checkbox" name="ids[]" value="{{ $license->id }}" class="license-checkbox"></td>
                                        <td class="p-2">{{ $license->vendo_box_no }}</td>
                                        <td class="p-2">{{ $license->vendo_machine }}</td>
                                        <td class="p-2" style="word-break: break-all;">{{ $license->license }}</td>
                                        <td class="p-2">{{ $license->device_id }}</td>
                                        <td class="p-2" style="word-break: break-all;">{{ $license->description }}</td>
                                        <td class="p-2">{{ $license->date }}</td>
                                        <td class="p-2">{{ $license->technician }}</td>
                                        <td class="p-2">{{ $license->email }}</td>
                                        <td class="p-2">{{ $license->customer_name }}</td>
                                        <td class="p-2" style="word-break: break-all;">{{ $license->address }}</td>
                                        <td class="p-2">{{ $license->contact }}</td>
                                        <td class="p-2 flex items-center">
                                            <button class="text-blue-500 hover:text-blue-700 mr-2">View</button>
                                            <button class="text-green-500 hover:text-green-700 mr-2">Edit</button>
                                            <button class="text-red-500 hover:text-red-700" onclick="showArchiveModal({{ $license->id }})">Archive</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <div class="flex items-center justify-between mt-4">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing {{ $licenses->firstItem() }} to {{ $licenses->lastItem() }} of {{ $licenses->total() }} results
                            </p>
                        </div>
                        <div>
                            {{ $licenses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Batch Upload Modal -->
<div id="batch-upload-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 transition-opacity duration-300 ease-in-out opacity-0">
    <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg p-6 transform transition-all duration-300 ease-in-out scale-95">
        <button id="close-upload-modal-button" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <h3 class="text-lg font-bold text-gray-800 mb-4">Batch Upload Licenses</h3>

        <div id="upload-form-container">
            <div class="mb-4">
                <button id="guide-button" class="text-blue-500 hover:underline">Use this guide</button>
                <div id="guide-content" class="hidden mt-2 p-4 bg-gray-100 rounded-lg">
                    <p>Your CSV or Excel file should have the following headers:</p>
                    <ul class="list-disc list-inside">
                        <li>vendo_box_no</li>
                        <li>vendo_machine</li>
                        <li>license</li>
                        <li>device_id</li>
                        <li>description</li>
                        <li>date</li>
                        <li>technician</li>
                        <li>email</li>
                        <li>customer_name</li>
                        <li>address</li>
                        <li>contact</li>
                    </ul>
                    <a href="/sample_imports/license_sample_imports.xlsx" class="text-blue-500 hover:underline mt-2 inline-block">Download sample Excel</a>
                    <a href="/sample_imports/license_sample_imports.csv" class="text-blue-500 hover:underline mt-2 inline-block ml-4">Download sample CSV</a>
                </div>
            </div>

            <form id="batch-upload-form" action="/licenses/import" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="upload-file">
                        Select File
                    </label>
                    <input type="file" name="file" id="upload-file" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div id="preview-container" class="mb-4 hidden">
                    <h4 class="font-bold">File Preview:</h4>
                    <div id="file-preview" class="mt-2 p-2 border rounded-lg bg-gray-50 max-h-48 overflow-auto"></div>
                </div>

                <div id="progress-container" class="w-full bg-gray-200 rounded-full h-2.5 mb-4 hidden">
                    <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="cancel-upload-button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Upload</button>
                </div>
            </form>
        </div>

        <div id="success-message" class="hidden text-center">
            <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <h3 class="text-lg font-bold text-gray-800 mt-4">Upload Successful!</h3>
        </div>
    </div>
</div>

    <!-- Add License Modal -->
    <div id="add-license-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 transition-opacity duration-300 ease-in-out opacity-0">
    <div class="relative bg-white rounded-lg shadow-xl w-full max-w-4xl p-4 transform transition-all duration-300 ease-in-out scale-95">
        <button id="close-modal-button" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <h3 class="text-lg font-bold text-gray-800 mb-3">Add New License</h3>

        <form action="/licenses" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="vendo_box_no">Vendo Box No</label>
                    <input type="text" name="vendo_box_no" id="vendo_box_no" placeholder="e.g., V123"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="vendo_machine">Vendo Machine</label>
                    <input type="text" name="vendo_machine" id="vendo_machine" placeholder="e.g., PISOFI-XYZ"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="license">License</label>
                    <input type="text" name="license" id="license" placeholder="Enter the license key"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="device_id">Device ID</label>
                    <input type="text" name="device_id" id="device_id" placeholder="Enter the device ID"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="date">Date</label>
                    <input type="date" name="date" id="date" placeholder="YYYY-MM-DD"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="description">Description</label>
                    <textarea name="description" id="description" placeholder="Add any relevant notes..." rows="2"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm"></textarea>
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="technician">Technician</label>
                    <input type="text" name="technician" id="technician" placeholder="e.g., John Doe"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="email">PISOFI Email / LPB Radius ID</label>
                    <input type="text" name="email" id="email" placeholder="e.g., customer@example.com"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="customer_name">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" placeholder="e.g., Jane Smith"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="address">Address</label>
                    <input type="text" name="address" id="address" placeholder="e.g., 123 Main St, Anytown"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
                <div class="mb-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="contact">Contact</label>
                    <input type="text" name="contact" id="contact" placeholder="e.g., 555-1234"
                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                </div>
            </div>

            <div class="flex justify-end mt-3 border-t pt-3">
                <button id="cancel-modal-button" type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 mr-2 transition-colors duration-300 ease-in-out text-sm">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300 ease-in-out text-sm">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<form id="archive-form" method="POST" class="hidden">@csrf</form>

<script>
    const addLicenseButton = document.getElementById('add-license-button');
    const addLicenseModal = document.getElementById('add-license-modal');
    const closeModalButton = document.getElementById('close-modal-button');
    const cancelModalButton = document.getElementById('cancel-modal-button');
    const batchUploadButton = document.getElementById('batch-upload-button');
    const batchUploadModal = document.getElementById('batch-upload-modal');
    const closeUploadModalButton = document.getElementById('close-upload-modal-button');
    const cancelUploadButton = document.getElementById('cancel-upload-button');
    const guideButton = document.getElementById('guide-button');
    const guideContent = document.getElementById('guide-content');
    const uploadFile = document.getElementById('upload-file');
    const previewContainer = document.getElementById('preview-container');
    const filePreview = document.getElementById('file-preview');
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('progress-bar');
    const uploadFormContainer = document.getElementById('upload-form-container');
    const successMessage = document.getElementById('success-message');
    const batchUploadForm = document.getElementById('batch-upload-form');

    function openModal(modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
        }, 10);
    }

    function closeModal(modal) {
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    addLicenseButton.addEventListener('click', () => {
        openModal(addLicenseModal);
    });
    
    batchUploadButton.addEventListener('click', () => {
        openModal(batchUploadModal);
    });

    closeModalButton.addEventListener('click', (e) => {
        e.preventDefault();
        closeModal(addLicenseModal);
    });

    cancelModalButton.addEventListener('click', (e) => {
        e.preventDefault();
        closeModal(addLicenseModal);
    });
    
    closeUploadModalButton.addEventListener('click', (e) => {
        e.preventDefault();
        closeModal(batchUploadModal);
    });

    cancelUploadButton.addEventListener('click', (e) => {
        e.preventDefault();
        closeModal(batchUploadModal);
    });

    guideButton.addEventListener('click', () => {
        guideContent.classList.toggle('hidden');
    });

    uploadFile.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            previewContainer.classList.remove('hidden');
            const reader = new FileReader();
            reader.onload = (e) => {
                filePreview.textContent = e.target.result;
            };
            reader.readAsText(file);
        } else {
            previewContainer.classList.add('hidden');
        }
    });

    batchUploadForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        progressContainer.classList.remove('hidden');

        const formData = new FormData(e.target);
        const xhr = new XMLHttpRequest();

        xhr.upload.addEventListener('progress', (e) => {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                progressBar.style.width = percentComplete + '%';
            }
        });

        xhr.addEventListener('load', () => {
            if (xhr.status === 200) {
                uploadFormContainer.classList.add('hidden');
                successMessage.classList.remove('hidden');
                 setTimeout(() => {
                    closeModal(batchUploadModal);
                    location.reload();
                }, 2000);
            } else {
                // Handle error
            }
        });

        xhr.open('POST', '/licenses/import');
        xhr.send(formData);
    });

    function showArchiveModal(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('archive-form');
                form.action = `/licenses/${id}/archive`;
                form.submit();
            }
        })
    }

    const bulkActionsMenu = document.getElementById('bulk-actions-menu');
    const bulkActionsDropdown = document.getElementById('bulk-actions-dropdown');

    bulkActionsMenu.addEventListener('click', () => {
        bulkActionsDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!bulkActionsMenu.contains(event.target)) {
            bulkActionsDropdown.classList.add('hidden');
        }
    });

    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.license-checkbox');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    const bulkForm = document.getElementById('bulk-form');
    const bulkArchive = document.getElementById('bulk-archive');
    const bulkDelete = document.getElementById('bulk-delete');

    bulkArchive.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Archive Selected',
            text: "Are you sure you want to archive the selected licenses?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive them!'
        }).then((result) => {
            if (result.isConfirmed) {
                bulkForm.action = '/licenses/bulk-archive';
                bulkForm.submit();
            }
        });
    });

    bulkDelete.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Delete Selected',
            text: "Are you sure you want to permanently delete the selected licenses? This action cannot be undone.",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                bulkForm.action = '/licenses/bulk-delete';
                bulkForm.submit();
            }
        });
    });
</script>


</body>

</html>
