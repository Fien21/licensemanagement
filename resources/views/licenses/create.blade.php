<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel - Add License</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="antialiased bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Add New License</h1>

        <form action="/licenses" method="POST">
            @csrf
            
            <!-- Main License Details Container -->
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sheet Name -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="sheet_name">Sheet Name</label>
                        <select name="sheet_name" id="sheet_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('sheet_name') border-red-500 @enderror">
                            <option value="">Select a sheet</option>
                            @foreach($sheetNames as $sheetName)
                                <option value="{{ $sheetName }}" {{ old('sheet_name') == $sheetName ? 'selected' : '' }}>{{ $sheetName }}</option>
                            @endforeach
                        </select>
                        @error('sheet_name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vendo Box No -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="vendo_box_no">Vendo Box No.</label>
                        <input type="text" name="vendo_box_no" id="vendo_box_no" value="{{ old('vendo_box_no') }}" placeholder="e.g., V123" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- License -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="license">License</label>
                        <input type="text" name="license" id="license" value="{{ old('license') }}" placeholder="Enter the license key" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Device ID -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="device_id">Device ID</label>
                        <input type="text" name="device_id" id="device_id" value="{{ old('device_id') }}" placeholder="Enter the device ID" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="date">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Technician -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="technician">Technician</label>
                        <input type="text" name="technician" id="technician" value="{{ old('technician') }}" placeholder="e.g., John Doe" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                        <textarea name="description" id="description" rows="3" placeholder="Add any relevant notes..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Separate Container for Customer Information -->
            <div class="bg-blue-50 border-t-4 border-blue-500 shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-lg font-bold text-blue-800 mb-4 border-b border-blue-200 pb-2">Customer Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- PISOFI Email -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">PISOFI Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="e.g., customer@example.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- LPB Radius ID -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="lpb_radius_id">LPB Radius ID</label>
                        <input type="text" name="lpb_radius_id" id="lpb_radius_id" value="{{ old('lpb_radius_id') }}" placeholder="e.g., LPB-12345" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Customer Name -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customer_name">Customer Name</label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" placeholder="e.g. Jane Smith" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Contact -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="contact">Contact</label>
                        <input type="text" name="contact" id="contact" value="{{ old('contact') }}" placeholder="e.g. 09123456789" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="e.g. 123 Street, City" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-200">Submit</button>
                <a href="/licenses" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800 bg-gray-200 px-4 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Script to Auto-fill User Data -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const lpbIdInput = document.getElementById('lpb_radius_id');
            const customerNameInput = document.getElementById('customer_name');
            const contactInput = document.getElementById('contact');
            const addressInput = document.getElementById('address');

            let timeout = null;

            function searchUser(value) {
                if (value.length < 3) return; // Don't search for very short strings

                fetch("{{ route('users.search') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ query: value })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.not_found) {
                        // Populate the fields with found data
                        customerNameInput.value = data.customer_name || '';
                        contactInput.value = data.contact || '';
                        addressInput.value = data.address || '';
                        
                        // Cross-fill the search fields if they are empty
                        if (!emailInput.value && data.email) emailInput.value = data.email;
                        if (!lpbIdInput.value && data.lpb_radius_id) lpbIdInput.value = data.lpb_radius_id;
                    }
                })
                .catch(error => console.error('Error fetching user:', error));
            }

            // Listen for input on Email
            emailInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => searchUser(this.value), 500);
            });

            // Listen for input on Radius ID
            lpbIdInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => searchUser(this.value), 500);
            });
        });
    </script>
</body>
</html>