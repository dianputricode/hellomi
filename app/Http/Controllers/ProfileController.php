<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $wishlists = [];
        $wishlistIds = [];

        if (Auth::check()) {
            $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();
            $wishlistIds = $wishlists->pluck('product_id')->toArray();
        }

        $user = Auth::user();

        return view('pages.user.profile', compact('wishlists', 'wishlistIds', 'user'));
    }



    public function edit()
    {
        $user = Auth::user();
        return view('pages.user.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->username . ',username',
            'phone_number' => 'required|string',
            'foto_profil' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->username = $request->input('username');
        $user->phone_number = $request->input('phone_number');

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('storage/profile_pictures'), $fileName);
            $user->profile_picture = 'storage/profile_pictures/' . $fileName;
        }


        $user->save();

        return redirect('/profil')->with('success', 'Profile updated successfully.');
    }
}
