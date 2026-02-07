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
</head>

<body class="antialiased bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Add New License</h1>

        <form action="/licenses" method="POST">
            @csrf
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
                    <input type="text" name="vendo_box_no" id="vendo_box_no" value="{{ old('vendo_box_no') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- License -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="license">License</label>
                    <input type="text" name="license" id="license" value="{{ old('license') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Device ID -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="device_id">Device ID</label>
                    <input type="text" name="device_id" id="device_id" value="{{ old('device_id') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="date">Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Technician -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="technician">Technician</label>
                    <input type="text" name="technician" id="technician" value="{{ old('technician') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

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
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Contact -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="contact">Contact</label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add License</button>
                <a href="/licenses" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>