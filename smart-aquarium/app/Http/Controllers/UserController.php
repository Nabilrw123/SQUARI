<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Kreait\Firebase\Factory;

class UserController extends Controller
{
    private $database;

    private $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase/firebase_credentials.json'))
            ->withDatabaseUri('https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app/');
        $this->database = $factory->createDatabase();
        $this->auth = $factory->createAuth();
    }

    private function logToFirebase($action, $status, $details)
    {
        $now = now();
        $timestamp = $now->format('d-m-Y_H:i:s');
        $userEmail = auth()->user() ? auth()->user()->email : 'anonymous';

        $this->database->getReference('dashboard/history/Kontrol/' . $timestamp)
            ->set([
                'timestamp' => $now->getTimestamp() * 1000,
                'action' => $action,
                'status' => $status,
                'details' => $details,
                'user' => $userEmail
            ]);
    }

    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        try {
            if ($validated['role'] === 'admin') {
                // Create user in Firebase Authentication
                $firebaseUser = $this->auth->createUser([
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'displayName' => $validated['name'],
                ]);

                // Create user in Laravel database
                $user = new User();
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->password = Hash::make($validated['password']);
                $user->role = $validated['role'];
                $user->firebase_uid = $firebaseUser->uid;
                $user->save();

                $this->logToFirebase(
                    'Create User',
                    'Success',
                    "Created new admin user: {$user->name} ({$user->email}) with Firebase UID: {$user->firebase_uid}"
                );
            } else {
                // Role is user, create only in Laravel database
                $user = new User();
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->password = Hash::make($validated['password']);
                $user->role = $validated['role'];
                $user->save();

                $this->logToFirebase(
                    'Create User',
                    'Success',
                    "Created new user: {$user->name} ({$user->email})"
                );
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            $this->logToFirebase(
                'Create User',
                'Failed',
                "Failed to create user: {$validated['email']}. Error: {$e->getMessage()}"
            );

            return back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        try {
            $oldData = [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ];

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->role = $validated['role'];
            $user->save();

            $changes = [];
            if ($oldData['name'] !== $user->name) $changes[] = "Name: {$oldData['name']} → {$user->name}";
            if ($oldData['email'] !== $user->email) $changes[] = "Email: {$oldData['email']} → {$user->email}";
            if ($oldData['role'] !== $user->role) $changes[] = "Role: {$oldData['role']} → {$user->role}";
            if (!empty($validated['password'])) $changes[] = "Password: Updated";

            $this->logToFirebase(
                'Update User',
                'Success',
                "Updated user {$user->name} ({$user->email}). Changes: " . implode(', ', $changes)
            );

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            $this->logToFirebase(
                'Update User',
                'Failed',
                "Failed to update user {$user->name} ({$user->email}). Error: {$e->getMessage()}"
            );

            return back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {
            $userData = [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'firebase_uid' => $user->firebase_uid
            ];
            
            // Delete user from Firebase Authentication if they have a firebase_uid
            if ($user->firebase_uid) {
                try {
                    $this->auth->deleteUser($user->firebase_uid);
                    $this->logToFirebase(
                        'Delete Firebase User',
                        'Success',
                        "Deleted Firebase user with UID: {$user->firebase_uid}"
                    );
                } catch (\Exception $firebaseError) {
                    $this->logToFirebase(
                        'Delete Firebase User',
                        'Failed',
                        "Failed to delete Firebase user {$user->firebase_uid}. Error: {$firebaseError->getMessage()}"
                    );
                    // Continue with local deletion even if Firebase deletion fails
                }
            }
            
            // Delete user from local database
            $user->delete();

            $this->logToFirebase(
                'Delete User',
                'Success',
                "Deleted user: {$userData['name']} ({$userData['email']}) with role: {$userData['role']}"
            );

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            $this->logToFirebase(
                'Delete User',
                'Failed',
                "Failed to delete user {$user->name} ({$user->email}). Error: {$e->getMessage()}"
            );

            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
