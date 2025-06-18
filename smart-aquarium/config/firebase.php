<?php

return [
    'database_url' => env('FIREBASE_DATABASE_URL', 'https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app'),
    'credentials_path' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase/firebase_credentials.json')),
    'project_id' => env('FIREBASE_PROJECT_ID', 'smart-aquarium-3720d'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', 'smart-aquarium-3720d.appspot.com'),
    'api_key' => env('FIREBASE_API_KEY'),
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN', 'smart-aquarium-3720d.firebaseapp.com'),
    'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
    'app_id' => env('FIREBASE_APP_ID'),
]; 