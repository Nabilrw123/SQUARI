<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FirebaseAuthController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function handle(Request $request)
    {
        $request->validate([
            'firebase_token' => 'required|string',
        ]);

        try {
            $verified = $this->firebaseService->verifyIdToken($request->firebase_token);
            if (!$verified) {
                return response()->json(['error' => 'Invalid Firebase token'], 401);
            }

            $uid = $verified->claims()->get('sub');
            $fbUser = $this->firebaseService->getAuth()->getUser($uid);

            $user = User::firstOrNew(['email' => $fbUser->email]);
            $user->name = $fbUser->displayName ?? $fbUser->email;
            $user->role = 'admin';
            $user->password = bcrypt(Str::random(16));
            $user->save();

            Auth::login($user);

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Firebase login error: ' . $e->getMessage());
            return response()->json(['error' => 'Firebase login failed'], 500);
        }
    }
}
