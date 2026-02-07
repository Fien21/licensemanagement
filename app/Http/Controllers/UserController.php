<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        $user = new User($request->all());
        $user->password = Hash::make(Str::random(10));
        $user->name = $request->customer_name;
        $user->save();


        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function archive(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User archived successfully.');
    }

    public function bulkArchive(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids) {
            User::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Selected users have been archived.');
        }
        return redirect()->back()->with('error', 'No users selected.');
    }

    public function archived()
    {
        $users = User::onlyTrashed()->get();
        return view('users.archived', compact('users'));
    }

    public function restore(Request $request, $id)
    {
        User::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', 'User restored successfully.');
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids) {
            User::withTrashed()->whereIn('id', $ids)->restore();
            return redirect()->back()->with('success', 'Selected users have been restored.');
        }
        return redirect()->back()->with('error', 'No users selected.');
    }

    public function delete(Request $request, $id)
    {
        User::withTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', 'User permanently deleted.');
    }
    
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids) {
            User::withTrashed()->whereIn('id', $ids)->forceDelete();
            return redirect()->back()->with('success', 'Selected users have been permanently deleted.');
        }
        return redirect()->back()->with('error', 'No users selected.');
    }
}
