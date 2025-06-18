<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Kreait\Firebase\Factory;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'max:1024']
        ]);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::exists('public/profile/' . $user->profile_image)) {
                Storage::delete('public/profile/' . $user->profile_image);
            }

            // Store new image
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->storeAs('public/profile', $imageName);
            $user->profile_image = $imageName;
        }

        $user->save();

        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase/firebase_credentials.json'))
            ->withDatabaseUri('https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app/');
        $database = $factory->createDatabase();
        $now = now();
        $userEmail = auth()->user() ? auth()->user()->email : 'anonymous';
        $database->getReference('dashboard/history/notifikasi/' . $now->format('d-m-Y_H:i:s'))
            ->set([
                'timestamp' => $now->getTimestamp() * 1000,
                'type' => 'success',
                'title' => 'Update Profile',
                'message' => 'Profile berhasil diperbarui',
                'user' => $userEmail
            ]);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }

    public function updateImage(Request $request)
    {
        try {
            $request->validate([
                'profile_image' => ['required', 'image', 'max:1024']
            ]);

            $user = Auth::user();

            // Delete old image if exists
            if ($user->profile_image && Storage::exists('public/profile/' . $user->profile_image)) {
                Storage::delete('public/profile/' . $user->profile_image);
            }

            // Store new image
            $imageName = time() . '_' . uniqid() . '.' . $request->profile_image->extension();
            $path = $request->profile_image->storeAs('public/profile', $imageName);
            
            if (!$path) {
                throw new \Exception('Failed to store image');
            }

            $user->profile_image = $imageName;
            $user->save();

            return response()->json([
                'success' => true,
                'image_url' => Storage::url('profile/' . $imageName)
            ]);
        } catch (\Exception $e) {
            \Log::error('Profile image upload failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy()
    {
        $user = auth()->user();

        if ($user) {
            auth()->logout();

            // Delete user
            $user->delete();

            return redirect('/')->with('success', 'Account deleted successfully.');
        }

        return redirect()->back()->withErrors('Failed to delete account.');
    }
}
