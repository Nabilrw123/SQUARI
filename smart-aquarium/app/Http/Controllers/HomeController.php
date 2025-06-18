<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class HomeController extends Controller
{
    protected $firebaseService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Show the welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            // Get sensor data from Firebase dashboard folder
            $sensorData = $this->firebaseService->getDatabase()
                ->getReference('dashboard/sensor')
                ->getValue();
            
            // Get system status from dashboard folder
            $statusData = $this->firebaseService->getDatabase()
                ->getReference('dashboard/status')
                ->getValue();

            // Get historical data from Firebase
            $historyData = $this->firebaseService->getDatabase()
                ->getReference('dashboard/history')
                ->getValue();

            return view('welcome', [
                'sensorData' => $sensorData,
                'statusData' => $statusData,
                'historyData' => $historyData
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching data from Firebase: ' . $e->getMessage());
            return view('welcome', [
                'sensorData' => null,
                'statusData' => null,
                'historyData' => null
            ]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $this->middleware('auth');
        return view('home');
    }
}
