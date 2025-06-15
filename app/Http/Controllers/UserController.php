<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\ProductHistory;

class UserController extends Controller
{
    public function index()
    {
        if (Gate::allows('access-admin')) {
            abort(403);
        }

        $user = Auth::user();

        $topProducts = Product::orderBy('sustainable_rating', 'desc')->take(3)->get();

        $latestHistory = ProductHistory::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        return view('user.dashboard', compact('topProducts', 'latestHistory'));
    }

    public function edit()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'avatar' => 'nullable|string',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->avatar = $request->avatar;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated!');
    }

}


