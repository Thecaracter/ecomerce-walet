<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserProfileController extends Controller
{
    public function edit()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:8',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && $user->photo != '2.jpg') {
                $oldPhotoPath = public_path('foto/profile/' . $user->photo);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }

            // Generate new filename
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();

            // Move new photo to public directory
            $photo->move(public_path('foto/profile'), $photoName);
            $validated['photo'] = $photoName;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('alert', ['type' => 'success', 'message' => 'Profile updated successfully']);
    }
}