@extends('layouts.app')
@section('content')
<div class="container py-4" style="padding-left:60px;">
    <h2 class="mb-4">Settings</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="row">
        <!-- Application Settings -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Application Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <select class="form-select" id="language" name="language">
                                <option value="en" {{ $settings['language'] === 'en' ? 'selected' : '' }}>English</option>
                                <option value="id" {{ $settings['language'] === 'id' ? 'selected' : '' }}>Indonesia</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="timezone" class="form-label">Timezone</label>
                            <select class="form-select" id="timezone" name="timezone">
                                <option value="Asia/Jakarta" {{ $settings['timezone'] === 'Asia/Jakarta' ? 'selected' : '' }}>Jakarta (GMT+7)</option>
                                <option value="Asia/Singapore" {{ $settings['timezone'] === 'Asia/Singapore' ? 'selected' : '' }}>Singapore (GMT+8)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Application Settings</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Account Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

 

<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>
<script>
// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyC6zxY_ljbhoQEMbZYHuDRNZ2GGUbswQes",
    authDomain: "smart-aquarium-3720d.firebaseapp.com",
    databaseURL: "https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "smart-aquarium-3720d",
    storageBucket: "smart-aquarium-3720d.firebasestorage.app",
    messagingSenderId: "135942126154",
    appId: "1:135942126154:web:8e4a38acbf4b5acddfc4b3"
};

// Initialize Firebase
let app;
let db;

try {
    if (!firebase.apps.length) {
        app = firebase.initializeApp(firebaseConfig);
        console.log('Firebase app initialized successfully');
    } else {
        app = firebase.app();
        console.log('Using existing Firebase app');
    }
    
    db = firebase.database();
    console.log('Firebase database initialized');
} catch (error) {
    console.error('Error initializing Firebase:', error);
}

function getCustomTimestamp() {
    const now = new Date();
    const pad = n => n.toString().padStart(2, '0');
    const day = pad(now.getDate());
    const month = pad(now.getMonth() + 1);
    const year = now.getFullYear();
    const hours = pad(now.getHours());
    const minutes = pad(now.getMinutes());
    const seconds = pad(now.getSeconds());
    return `${day}-${month}-${year}_${hours}:${minutes}:${seconds}`;
}

function simpanKontrolHistory(action, status, user) {
    const waktu = getCustomTimestamp();
    db.ref('dashboard/history/notifikasi/' + waktu).set({
        waktu: waktu,
        action: action,
        status: status,
        user: user
    });
}

// Add function to save settings to notification history
function simpanNotifikasiHistory(type, title, message) {
    const waktu = getCustomTimestamp();
    db.ref('dashboard/history/notifikasi/' + waktu).set({
        waktu: waktu,
        type: type,
        title: title,
        message: message
    });
}

// Initialize settings reference
const settingsRef = db.ref('dashboard/settings');

// Load current settings
settingsRef.on('value', (snapshot) => {
    const settings = snapshot.val() || {};
    // Update form fields with current settings
    if (settings.language) document.getElementById('language').value = settings.language;
    if (settings.timezone) document.getElementById('timezone').value = settings.timezone;
    if (settings.email_notifications) document.getElementById('email_notifications').checked = settings.email_notifications;
    if (settings.push_notifications) document.getElementById('push_notifications').checked = settings.push_notifications;
});

// Add event listener for application settings form
document.addEventListener('DOMContentLoaded', function() {
    const appSettingsForm = document.querySelector('form[action="{{ route("settings.update") }}"]');
    if (appSettingsForm) {
        let firebaseSaved = false;
        appSettingsForm.addEventListener('submit', async function(e) {
            if (!firebaseSaved) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(appSettingsForm);
                const settings = {
                    language: formData.get('language'),
                    timezone: formData.get('timezone'),
                    email_notifications: formData.get('email_notifications') === '1',
                    push_notifications: formData.get('push_notifications') === '1'
                };

                try {
                    // Save to Firebase
                    await db.ref('dashboard/settings').set(settings);
                    
                    // Save to notification history
                    simpanNotifikasiHistory(
                        'success',
                        'Pengaturan Aplikasi Diperbarui',
                        `Pengaturan aplikasi berhasil diperbarui:\n` +
                        `- Bahasa: ${settings.language === 'id' ? 'Indonesia' : 'English'}\n` +
                        `- Timezone: ${settings.timezone}\n` +
                        `- Notifikasi Email: ${settings.email_notifications ? 'Aktif' : 'Nonaktif'}\n` +
                        `- Notifikasi Push: ${settings.push_notifications ? 'Aktif' : 'Nonaktif'}`
                    );

                    firebaseSaved = true;
                    appSettingsForm.submit();
                } catch (error) {
                    console.error('Error saving settings:', error);
                    simpanNotifikasiHistory(
                        'danger',
                        'Gagal Memperbarui Pengaturan',
                        'Terjadi kesalahan saat menyimpan pengaturan aplikasi: ' + error.message
                    );
                }
            }
        });
    }
});

// Notification function
function showNotif(type, message) {
    const notif = document.createElement('div');
    notif.className = `alert alert-${type} alert-dismissible fade show`;
    notif.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.querySelector('.container').insertBefore(notif, document.querySelector('.row'));
    setTimeout(() => notif.remove(), 5000);
}
</script>
@endsection
