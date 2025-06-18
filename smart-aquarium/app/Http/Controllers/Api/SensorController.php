<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function getSensorData()
    {
        try {
            $data = $this->firebaseService->getSensorData();
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Error fetching sensor data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch sensor data'], 500);
        }
    }
} 