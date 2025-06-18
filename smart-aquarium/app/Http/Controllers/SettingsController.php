<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings', [
            'user' => $user,
            'settings' => [
                'language' => $user->settings->language ?? 'en',
                'timezone' => $user->settings->timezone ?? 'Asia/Jakarta',
                'email_notifications' => $user->settings->email_notifications ?? true,
                'push_notifications' => $user->settings->push_notifications ?? true,
            ]
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|in:en,id',
            'timezone' => 'required|in:Asia/Jakarta,Asia/Singapore',
            'email_notifications' => 'nullable|boolean',
            'push_notifications' => 'nullable|boolean',
        ]);

        $validated['email_notifications'] = $request->has('email_notifications');
        $validated['push_notifications'] = $request->has('push_notifications');

        $user = Auth::user();
        
        // Update user settings
        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        // Catat ke Firebase history
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
                'title' => 'Update Setting',
                'message' => 'Pengaturan aplikasi berhasil diperbarui',
                'user' => $userEmail
            ]);

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
} 