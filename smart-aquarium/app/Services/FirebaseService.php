<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\ServiceAccount;

class FirebaseService
{
    protected $firebase;
    protected $auth;

    public function __construct()
    {
        try {
            $credentialsPath = storage_path('app/firebase/firebase_credentials.json');
            if (!file_exists($credentialsPath)) {
                throw new \Exception('Firebase credentials file not found at: ' . $credentialsPath);
            }

            $credentials = json_decode(file_get_contents($credentialsPath), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON in Firebase credentials file');
            }

            $factory = (new Factory)
                ->withServiceAccount($credentialsPath)
                ->withDatabaseUri('https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app');

            $this->firebase = $factory->createDatabase();
            $this->auth = $factory->createAuth();

            \Log::info('Firebase connection established successfully');
        } catch (\Exception $e) {
            \Log::error('Firebase connection error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getDatabase()
    {
        return $this->firebase;
    }

    public function getAuth()
    {
        return $this->auth;
    }

    public function verifyIdToken(string $idToken)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            return $verifiedIdToken;
        } catch (FailedToVerifyToken $e) {
            \Log::error('Failed to verify Firebase ID token: ' . $e->getMessage());
            return null;
        }
    }

    public function initializeData()
    {
        try {
            $initialData = [
                'aquarium' => [
                    'data' => [
                        'suhu_air' => 0,
                        'suhu_udara' => 0,
                        'kelembapan' => 0,
                        'level_air' => 'Normal',
                        'waktu_update' => date('Y-m-d H:i:s')
                    ],
                    'command' => [
                        'pompa' => false,
                        'pakan' => false,
                        'lampu' => false
                    ],
                    'settings' => [
                        'batas_suhu_air' => 28,
                        'batas_suhu_udara' => 30,
                        'batas_kelembapan' => 80,
                        'batas_level_air_min' => 20,
                        'batas_level_air_max' => 80
                    ]
                ]
            ];

            $this->firebase->getReference('/')->set($initialData);
            \Log::info('Data initialized successfully', ['data' => $initialData]);
            return true;
        } catch (DatabaseException $e) {
            \Log::error('Error initializing data: ' . $e->getMessage());
            return false;
        }
    }

    public function getSensorData()
    {
        try {
            $data = $this->firebase->getReference('aquarium/data')->getValue();
            \Log::info('Retrieved sensor data', ['data' => $data]);
            
            if (empty($data)) {
                \Log::warning('No sensor data found, initializing...');
                $this->initializeData();
                $data = $this->firebase->getReference('aquarium/data')->getValue();
            }
            
            // Ensure all required keys exist
            $defaultData = [
                'suhu_air' => 0,
                'suhu_udara' => 0,
                'kelembapan' => 0,
                'level_air' => 'Normal',
                'waktu_update' => date('Y-m-d H:i:s')
            ];
            
            $data = array_merge($defaultData, $data ?? []);
            
            // Update level_air status based on value
            if (isset($data['level_air']) && is_numeric($data['level_air'])) {
                $settings = $this->firebase->getReference('aquarium/settings')->getValue();
                $minLevel = $settings['batas_level_air_min'] ?? 20;
                $maxLevel = $settings['batas_level_air_max'] ?? 80;
                
                if ($data['level_air'] < $minLevel) {
                    $data['level_air'] = 'Rendah';
                } elseif ($data['level_air'] > $maxLevel) {
                    $data['level_air'] = 'Tinggi';
                } else {
                    $data['level_air'] = 'Normal';
                }
            }
            
            return $data;
        } catch (DatabaseException $e) {
            \Log::error('Error fetching sensor data: ' . $e->getMessage());
            return [
                'suhu_air' => 0,
                'suhu_udara' => 0,
                'kelembapan' => 0,
                'level_air' => 'Normal',
                'waktu_update' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function updateCommand($path, $value)
    {
        try {
            return $this->firebase->getReference($path)->set($value);
        } catch (DatabaseException $e) {
            \Log::error('Error updating command: ' . $e->getMessage());
            return false;
        }
    }
}
