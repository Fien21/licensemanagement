<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Manager | {{ config('app.name', 'License Management') }}</title>

<!-- Tailwind, SweetAlert2, Particles.js -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js"></script>

<style>
    /* Font & Body styling from second HTML */
    body {
        font-family: 'Figtree', sans-serif;
        background-color: #0b1e3b;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 0;
        top: 0;
        left: 0;
    }

    #dashboard-container {
        position: relative;
        z-index: 10;
        display: flex;
        height: 100vh;
    }

    /* Top Bar */
    .top-bar {
        background-color: #082146;
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        z-index: 20;
    }

    .top-bar img {
        height: 40px;
        margin-right: 0.75rem;
    }

    /* Table Cards */
    .table-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }

    .table-hover tr:hover {
        background-color: #eff6ff;
    }

    /* Buttons */
    .btn-primary { background-color: #3b82f6; color: white; }
    .btn-primary:hover { background-color: #2563eb; }
    .btn-danger { background-color: #ef4444; color: white; }
    .btn-danger:hover { background-color: #b91c1c; }

    /* Input & Label font styling from second HTML */
    input, select, textarea, label {
        font-family: 'Figtree', sans-serif;
    }
</style>
</head>
<body>

<!-- Particles Background -->
<div id="particles-js"></div>

<div id="dashboard-container">
    <!-- Sidebar -->
    @include('sidebar') <!-- your reusable sidebar component -->

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top Bar -->
        <div class="top-bar">
            <img src="{{ asset('images/astik.jpg') }}" alt="Logo">
            <span class="font-bold text-lg text-white">AZTECH Compute Enterprises Inc.</span>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            <h1 class="text-3xl font-bold text-white">User Manager</h1>

            <!-- SweetAlert Flash Messages -->
            @if(session('success'))
                <script>
                    window.onload = () => Swal.fire({ icon: 'success', title: 'Success!', text: "{{ session('success') }}", confirmButtonColor: '#10b981' });
                </script>
            @endif
            @if(session('error'))
                <script>
                    window.onload = () => Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}", confirmButtonColor: '#ef4444' });
                </script>
            @endif

            <!-- Search/Filter Section -->
            <div class="table-card">
                <form action="{{ route('users.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-bold text-gray-700 uppercase tracking-widest mb-2">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                class="block w-full px-4 py-3 rounded-xl border-gray-300 bg-gray-50 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search name, email, radius ID, address, contact...">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary px-6 py-2 rounded font-semibold">Apply Filters</button>
                    </div>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4">
                <button id="add-user-button" class="px-6 py-3 rounded-xl shadow-lg bg-green-600 text-white hover:bg-green-700 font-bold">+ Add New User</button>
            </div>

            <!-- User Table -->
            <div class="table-card overflow-x-auto">
                <form id="bulk-form" method="POST" action="{{ route('users.bulkArchive') }}">
                    @csrf
                    <div class="flex justify-start mb-4">
                        <button type="submit" class="btn-danger px-4 py-2 rounded font-semibold">Archive Selected</button>
                    </div>

                    <table class="w-full table-auto table-hover text-gray-700">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="p-3 rounded-tl-lg"><input type="checkbox" id="select-all" class="w-5 h-5 rounded accent-blue-500"></th>
                                <th class="p-3 text-left font-semibold">Email</th>
                                <th class="p-3 text-left font-semibold">LPB Radius ID</th>
                                <th class="p-3 text-left font-semibold">Customer Name</th>
                                <th class="p-3 text-left font-semibold">Address</th>
                                <th class="p-3 text-left font-semibold">Contact</th>
                                <th class="p-3 text-left font-semibold rounded-tr-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                            <tr>
                                <td class="p-3"><input type="checkbox" name="ids[]" value="{{ $user->id }}" class="user-checkbox w-5 h-5 rounded accent-blue-500"></td>
                                <td class="p-3 font-medium">{{ $user->email }}</td>
                                <td class="p-3 font-medium">{{ $user->radius_id }}</td>
                                <td class="p-3 font-bold">{{ $user->customer_name }}</td>
                                <td class="p-3">{{ $user->address }}</td>
                                <td class="p-3">{{ $user->contact }}</td>
                                <td class="p-3 flex space-x-2">
                                    <a href="{{ route('users.edit', $user) }}" class="btn-primary px-3 py-1 rounded font-semibold">Edit</a>
                                    <button type="button" data-action="{{ route('users.archive', $user->id) }}" class="btn-danger px-3 py-1 rounded individual-archive-btn font-semibold">Archive</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($users->isEmpty())
                        <div class="text-center py-10 text-gray-500 italic">No users found.</div>
                    @endif
                </form>

                <form id="single-archive-form" method="POST" style="display:none;">@csrf</form>
            </div>
        </div>
    </div>
</div>

<script>
    // Particles.js
    particlesJS('particles-js',{
        particles:{number:{value:80,density:{enable:true,value_area:800}},color:{value:'#ffffff'},
        shape:{type:'circle'},opacity:{value:0.5,random:true},size:{value:3,random:true},
        line_linked:{enable:true,opacity:0.1},move:{enable:true,speed:1,direction:'none',out_mode:'bounce'}},
        interactivity:{events:{onhover:{enable:true,mode:'repulse'}}},retina_detect:true
    });

    // Select all checkboxes
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.user-checkbox');
    selectAll?.addEventListener('change', function(){ checkboxes.forEach(c => c.checked = this.checked); });

    // Individual Archive
    document.querySelectorAll('.individual-archive-btn').forEach(btn=>{
        btn.addEventListener('click', function(){
            const singleForm = document.getElementById('single-archive-form');
            Swal.fire({
                title:'Move to Archive?',
                text:'This specific user will be archived.',
                icon:'warning',
                showCancelButton:true,
                confirmButtonColor:'#ef4444',
                cancelButtonColor:'#3085d6',
                confirmButtonText:'Yes, Archive User'
            }).then(result=>{ if(result.isConfirmed){ singleForm.action = btn.dataset.action; singleForm.submit(); } });
        });
    });

    // Bulk Archive
    document.getElementById('bulk-form').addEventListener('submit', function(e){
        e.preventDefault();
        const selected = document.querySelectorAll('.user-checkbox:checked');
        if(selected.length===0){ Swal.fire('No selection','Please select at least one user.','info'); return; }
        Swal.fire({
            title:`Archive ${selected.length} Users?`,
            text:'Proceed to archive the selected users?',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#ef4444',
            cancelButtonColor:'#3085d6',
            confirmButtonText:'Yes, Archive Selected'
        }).then(result=>{ if(result.isConfirmed) this.submit(); });
    });
</script>
</body>
</html>
