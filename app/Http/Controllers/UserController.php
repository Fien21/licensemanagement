<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    public function archived()
    {
        $users = User::onlyTrashed()->get();
        return view('users.archived', compact('users'));
    }

    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', 'User restored successfully.');
    }

    public function delete($id)
    {
        User::withTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', 'User permanently deleted.');
    }
}