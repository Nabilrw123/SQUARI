<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            try {
                // Get sensor data from Firebase dashboard folder
                $sensorData = $this->firebaseService->getDatabase()
                    ->getReference('dashboard/sensor')
                    ->getValue();
                
                // Get command status from dashboard folder
                $commandData = $this->firebaseService->getDatabase()
                    ->getReference('dashboard/control')
                    ->getValue();

                // Get system status from dashboard folder
                $statusData = $this->firebaseService->getDatabase()
                    ->getReference('dashboard/status')
                    ->getValue();

                return view('dashboard', [
                    'sensorData' => $sensorData,
                    'commandData' => $commandData,
                    'statusData' => $statusData
                ]);
            } catch (\Exception $e) {
                \Log::error('Error fetching data from Firebase: ' . $e->getMessage());
                return view('dashboard', [
                    'sensorData' => null,
                    'commandData' => null,
                    'statusData' => null
                ]);
            }
        } elseif ($user->role === 'user') {
            try {
                // Get sensor data from Firebase dashboard folder
                $sensorData = $this->firebaseService->getDatabase()
                    ->getReference('dashboard/sensor')
                    ->getValue();
                
                // Get system status from dashboard folder
                $statusData = $this->firebaseService->getDatabase()
                    ->getReference('dashboard/status')
                    ->getValue();

                return view('dashboard-user', [
                    'sensorData' => $sensorData,
                    'statusData' => $statusData
                ]);
            } catch (\Exception $e) {
                \Log::error('Error fetching data from Firebase: ' . $e->getMessage());
                return view('dashboard-user', [
                    'sensorData' => null,
                    'statusData' => null
                ]);
            }
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function control(Request $request)
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            return back()->with('error', 'Unauthorized access.');
        }

        $device = $request->input('device');
        $status = $request->input('status');

        if (!$device || !$status) {
            return back()->with('error', 'Invalid device or status.');
        }

        // Map device names to Firebase paths
        $deviceMap = [
            'feeding' => 'aquarium/command/pakan',
            'filter' => 'aquarium/command/pompa',
            'lamp' => 'aquarium/command/lampu'
        ];

        // Map status values to boolean
        $statusMap = [
            'on' => true,
            'off' => false
        ];

        if (!isset($deviceMap[$device]) || !isset($statusMap[$status])) {
            return back()->with('error', 'Invalid device or status value.');
        }

        try {
            $this->firebaseService->getDatabase()
                ->getReference($deviceMap[$device])
                ->set($statusMap[$status]);

            // Simpan ke history/controls
            $log = [
                'action' => $device,
                'status' => $status,
                'user' => Auth::user() ? Auth::user()->email : 'unknown',
                'timestamp' => round(microtime(true) * 1000)
            ];
            $this->firebaseService->getDatabase()
                ->getReference('dashboard/history/controls/' . $log['timestamp'])
                ->set($log);

            $statusMessage = [
                'feeding' => 'Pakan berhasil diberikan',
                'filter' => $status === 'on' ? 'Filter berhasil dinyalakan' : 'Filter berhasil dimatikan',
                'lamp' => $status === 'on' ? 'Lampu berhasil dinyalakan' : 'Lampu berhasil dimatikan'
            ];

            return back()->with('status', $statusMessage[$device]);
        } catch (\Exception $e) {
            \Log::error('Firebase command error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim perintah ke perangkat.');
        }
    }

    public function sensorData()
    {
        try {
            $sensorData = $this->firebaseService->getDatabase()
                ->getReference('dashboard/sensor')
                ->getValue();
            return view('sensor-data', compact('sensorData'));
        } catch (\Exception $e) {
            \Log::error('Error fetching sensor data from Firebase: ' . $e->getMessage());
            return view('sensor-data', ['sensorData' => null]);
        }
    }

    public function schedules()
    {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return view('schedules');
        } else {
            return view('schedules-user');
        }
    }
}
