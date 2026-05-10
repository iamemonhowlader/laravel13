<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'     => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'total_otps'      => Otp::count(),
            'active_sessions' => User::whereNotNull('updated_at')->count(),
        ];

        $recent_users = User::latest()->take(10)->get();

        return view('backend.layouts.dashboard.index', compact('stats', 'recent_users'));
    }

    public function users(Request $request)
    {
        $users = User::when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        })->latest()->paginate(15);

        return view('backend.layouts.users.index', compact('users'));
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
