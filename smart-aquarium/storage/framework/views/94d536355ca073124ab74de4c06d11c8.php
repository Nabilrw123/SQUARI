

<?php $__env->startSection('content'); ?>
<!-- Aquarium Background -->
<div class="aquarium-bg">
    <div class="bubbles"></div>
    <div class="water-particles">
        <?php for($i = 0; $i < 32; $i++): ?>
            <div class="particle"></div>
        <?php endfor; ?>
    </div>
    <div class="fish fish-1"></div>
    <div class="fish fish-2"></div>
    <div class="fish fish-3"></div>
    <div class="fish fish-4"></div>
    <div class="fish fish-5"></div>
    <div class="fish fish-6"></div>
</div>

<div class="main-content">
    <!-- Top Navbar -->
    <nav class="navbar">
        <div class="container-fluid p-0">
            <h4 class="mb-0">User Dashboard</h4>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <div class="dropdown">
                    <button class="btn btn-link text-dark text-decoration-none dropdown-toggle d-flex align-items-center gap-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo e(asset('/storage' . (auth()->user()->profile_image ?? 'default-profile.png'))); ?>" alt="Profile" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                        <span><?php echo e(auth()->user()->name); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal" role="button" tabindex="0" aria-pressed="false">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                            <button class="dropdown-item text-danger" type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Live Clock Modern Centered -->
    <div class="d-flex flex-column align-items-center my-4">
        <div id="liveClockModern" class="live-clock-modern">
            <i class="bi bi-clock"></i>
            <span id="clockTimeModern"></span>
        </div>
        <div id="clockDateModern" class="live-clock-date"></div>
    </div>

    <!-- Firebase Connection Status -->
    <div id="firebaseStatus" class="alert alert-info">
        Memeriksa koneksi Firebase...
    </div>

    <!-- Sensor Data Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card temp">
                <div>
                    <div class="stat-value" id="suhuAir"><?php echo e($sensorData['suhu_ds18b20'] ?? '--'); ?>°C</div>
                    <div class="stat-label">Suhu Air</div>
                    <div class="trend">
                        <i class="bi bi-arrow-up-short"></i> <span id="suhuTrend">0.0</span>°C dari sebelumnya
                    </div>
                </div>
                <i class="bi bi-thermometer-half stat-icon"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card temp">
                <div>
                    <div class="stat-value" id="suhuBME"><?php echo e($sensorData['suhu_bme280'] ?? '--'); ?>°C</div>
                    <div class="stat-label">Suhu Udara</div>
                    <div class="trend">
                        <i class="bi bi-arrow-up-short"></i> <span id="suhuBmeTrend">0.0</span>°C dari sebelumnya
                    </div>
                </div>
                <i class="bi bi-thermometer-half stat-icon"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card humidity">
                <div>
                    <div class="stat-value" id="kelembaban"><?php echo e($sensorData['kelembapan'] ?? '--'); ?>%</div>
                    <div class="stat-label">Kelembaban</div>
                    <div class="trend">
                        <i class="bi bi-arrow-up-short"></i> <span id="humidityTrend">0.0</span>% dari sebelumnya
                    </div>
                </div>
                <i class="bi bi-droplet-fill stat-icon"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card pressure">
                <div>
                    <div class="stat-value" id="tekanan"><?php echo e($sensorData['tekanan'] ?? '--'); ?> hPa</div>
                    <div class="stat-label">Tekanan Udara</div>
                    <div class="trend">
                        <i class="bi bi-arrow-up-short"></i> <span id="pressureTrend">0.0</span> hPa dari sebelumnya
                    </div>
                </div>
                <i class="bi bi-speedometer2 stat-icon"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card water">
                <div>
                    <div class="stat-value" id="levelAir"><?php echo e($sensorData['level_air'] ?? '--'); ?>%</div>
                    <div class="stat-label">Level Air</div>
                    <div class="trend">
                        <i class="bi bi-arrow-up-short"></i> <span id="waterTrend">0.0</span>% dari sebelumnya
                    </div>
                </div>
                <i class="bi bi-water stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Status Sistem</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="status-indicator <?php echo e($statusData['buzzer'] ?? false ? 'active' : ''); ?>"></div>
                                <span class="ms-2">Buzzer: <?php echo e($statusData['buzzer'] ?? false ? 'Aktif' : 'Nonaktif'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="status-indicator"></div>
                                <span class="ms-2">Level Air Rendah: <?php echo e($statusData['water_level_low'] ?? '--'); ?>%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="status-indicator"></div>
                                <span class="ms-2">Level Air Tinggi: <?php echo e($statusData['water_level_high'] ?? '--'); ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Control Cards -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pakan Ikan</h5>
                </div>
                <div class="card-body">
                    <div class="control-card">
                        <div class="control-icon">
                            <i class="fas fa-fish"></i>
                        </div>
                        <div class="control-info">
                            <h3>Pakan Ikan</h3>
                            <p>Kontrol pemberian pakan manual</p>
                        </div>
                        <button id="pakanButtonDashboard" class="btn btn-primary">
                            <i class="fas fa-broadcast"></i> Beri Pakan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer with timestamp -->
    <div class="d-flex justify-content-end mt-4">
        <span class="badge-time" id="lastUpdateDashboard">
            <i class="bi bi-clock"></i> Terakhir update: <span id="dashboardTime"><?php echo e(now()->format('H:i:s')); ?></span>
        </span>
    </div>
</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Profile Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="profile-container">
                    <div class="profile-header text-center">
                        <div class="profile-image-container" id="uploadTrigger">
                            <img src="<?php echo e(asset('storage/' . (auth()->user()->profile_image ?? 'default-profile.png'))); ?>" 
                                 alt="Profile" 
                                 id="profileImage" 
                                 class="profile-image">
                            <div class="profile-image-overlay">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <input type="file" 
                               id="profileImageInput" 
                               accept="image/*" 
                               class="d-none">
                        <h3 class="profile-name mt-3"><?php echo e(auth()->user()->name); ?></h3>
                        <p class="profile-role"><?php echo e(auth()->user()->email); ?></p>
                    </div>
                    <div class="profile-details">
                        <div class="profile-info-item">
                            <label><i class="fas fa-envelope me-2"></i>Email</label>
                            <p><?php echo e(auth()->user()->email); ?></p>
                        </div>
                        <div class="profile-info-item">
                            <label><i class="fas fa-user me-2"></i>Nama</label>
                            <p><?php echo e(auth()->user()->name); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    /* Aquarium Background Styles */
    .aquarium-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, #1a237e 0%, #0d47a1 100%);
        z-index: -1;
        overflow: hidden;
    }

    .bubbles {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
        top: 0;
        left: 0;
    }

    .bubbles::before,
    .bubbles::after {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        top: -50%;
        left: -50%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 60%);
        animation: bubble 15s linear infinite;
    }

    .bubbles::after {
        animation-delay: -7.5s;
    }

    @keyframes bubble {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .water-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: float 20s infinite linear;
    }

    @keyframes float {
        0% {
            transform: translateY(0) translateX(0);
            opacity: 0;
        }
        50% {
            opacity: 0.8;
        }
        100% {
            transform: translateY(-100vh) translateX(100px);
            opacity: 0;
        }
    }

    .fish {
        position: absolute;
        width: 50px;
        height: 30px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        animation: swim 20s infinite linear;
    }

    @keyframes swim {
        0% {
            transform: translateX(-100px) translateY(0);
        }
        50% {
            transform: translateX(calc(100vw + 100px)) translateY(-50px);
        }
        100% {
            transform: translateX(-100px) translateY(0);
        }
    }

    .fish-1 { top: 20%; animation-delay: 0s; }
    .fish-2 { top: 40%; animation-delay: -5s; }
    .fish-3 { top: 60%; animation-delay: -10s; }
    .fish-4 { top: 80%; animation-delay: -15s; }
    .fish-5 { top: 30%; animation-delay: -7s; }
    .fish-6 { top: 70%; animation-delay: -12s; }

    /* Live Clock Styles */
    .live-clock-modern {
        background: linear-gradient(90deg, #2196F3 0%, #06b6d4 100%);
        color: #fff;
        font-size: 2.5rem;
        font-weight: bold;
        padding: 18px 48px;
        border-radius: 50px;
        box-shadow: 0 4px 24px rgba(33,150,243,0.18), 0 0 0 6px rgba(33,150,243,0.08);
        letter-spacing: 3px;
        display: flex;
        align-items: center;
        gap: 18px;
        border: 2px solid #fff;
        animation: glow 2s infinite alternate;
    }

    .live-clock-modern i {
        font-size: 2.2rem;
        margin-right: 10px;
    }

    .live-clock-date {
        color: #2196F3;
        font-size: 1.2rem;
        font-weight: 500;
        margin-top: 10px;
        letter-spacing: 1px;
        text-shadow: 0 1px 2px #fff;
    }

    @keyframes glow {
        from { box-shadow: 0 4px 24px rgba(33,150,243,0.18), 0 0 0 6px rgba(33,150,243,0.08);}
        to   { box-shadow: 0 4px 32px rgba(33,150,243,0.32), 0 0 0 12px rgba(33,150,243,0.12);}
    }

    /* Stat Card Styles */
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.temp {
        background: linear-gradient(135deg, #fef3c7 0%, #fbbf24 100%);
    }

    .stat-card.humidity {
        background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%);
    }

    .stat-card.pressure {
        background: linear-gradient(135deg, #f3e8ff 0%, #d8b4fe 100%);
    }

    .stat-card.water {
        background: linear-gradient(135deg, #e0f2fe 0%, #7dd3fc 100%);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .trend {
        font-size: 0.8rem;
        color: #64748b;
    }

    .stat-icon {
        font-size: 2.5rem;
        color: rgba(0, 0, 0, 0.1);
    }

    /* Status Indicator Styles */
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #e2e8f0;
        transition: background-color 0.3s ease;
    }

    .status-indicator.active {
        background-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
    }

    /* Control Card Styles */
    .control-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .control-card:hover {
        transform: translateY(-5px);
    }

    .control-icon {
        width: 50px;
        height: 50px;
        background: #e3f2fd;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #2196F3;
    }

    .control-info {
        flex: 1;
    }

    .control-info h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .control-info p {
        margin: 0;
        font-size: 0.9rem;
        color: #64748b;
    }

    /* Profile Modal Styles */
    .profile-container {
        padding: 1rem;
    }

    .profile-header {
        margin-bottom: 2rem;
    }

    .profile-image-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
        position: relative;
        cursor: pointer;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .profile-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .profile-image-container:hover .profile-image-overlay {
        opacity: 1;
    }

    .profile-image-container:hover .profile-image {
        transform: scale(1.1);
    }

    .profile-image-overlay i {
        color: #ffffff;
        font-size: 2rem;
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }

    .profile-image-container:hover .profile-image-overlay i {
        transform: translateY(0);
    }

    .profile-name {
        font-size: 1.75rem;
        font-weight: 600;
        color: #1e293b;
        margin: 1.5rem 0 0.5rem;
    }

    .profile-role {
        font-size: 1.1rem;
        color: #64748b;
        margin: 0;
    }

    .profile-details {
        background: #f8fafc;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .profile-info-item {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .profile-info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .profile-info-item label {
        display: block;
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .profile-info-item label i {
        color: #2196F3;
    }

    .profile-info-item p {
        font-size: 1.1rem;
        color: #1e293b;
        font-weight: 500;
        margin: 0;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
<script>
// Initialize Firebase
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

// Live Clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit',
        hour12: false 
    });
    const dateString = now.toLocaleDateString('id-ID', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    
    document.getElementById('clockTimeModern').textContent = timeString;
    document.getElementById('clockDateModern').textContent = dateString;
}

setInterval(updateClock, 1000);
updateClock();

// Firebase Connection Status
const firebaseStatus = document.getElementById('firebaseStatus');
let lastUpdate = new Date();

function updateFirebaseStatus() {
    const now = new Date();
    const diff = now - lastUpdate;
    
    if (diff > 10000) { // More than 10 seconds since last update
        firebaseStatus.className = 'alert alert-danger';
        firebaseStatus.textContent = 'Koneksi Firebase terputus!';
    } else {
        firebaseStatus.className = 'alert alert-success';
        firebaseStatus.textContent = 'Terhubung ke Firebase';
    }
}

setInterval(updateFirebaseStatus, 5000);

// Sensor Data Updates
const sensorRef = db.ref('dashboard/sensor');
sensorRef.on('value', snapshot => {
    const data = snapshot.val();
    if (data) {
        lastUpdate = new Date();
        
        // Update sensor values
        document.getElementById('suhuAir').textContent = `${data.suhu_ds18b20 || '--'}°C`;
        document.getElementById('suhuBME').textContent = `${data.suhu_bme280 || '--'}°C`;
        document.getElementById('kelembaban').textContent = `${data.kelembapan || '--'}%`;
        document.getElementById('tekanan').textContent = `${data.tekanan || '--'} hPa`;
        document.getElementById('levelAir').textContent = `${data.level_air || '--'}%`;
        
        // Update last update time
        const lastUpdateElement = document.getElementById('lastUpdateDashboard');
        if (lastUpdateElement) {
            const now = new Date();
            lastUpdateElement.innerHTML = `<i class="bi bi-clock"></i> Terakhir update: ${now.toLocaleTimeString()}`;
        }
    }
});

// System Status Updates
const statusRef = db.ref('dashboard/status');
statusRef.on('value', snapshot => {
    const data = snapshot.val();
    if (data) {
        const buzzerStatus = document.querySelector('.status-indicator');
        if (buzzerStatus) {
            if (data.buzzer) {
                buzzerStatus.classList.add('active');
            } else {
                buzzerStatus.classList.remove('active');
            }
        }
    }
});

// Feed Button
const pakanButton = document.getElementById('pakanButtonDashboard');
if (pakanButton) {
    pakanButton.onclick = async function() {
        try {
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
            
            // Update status pakan di Firebase
            await db.ref('dashboard/control/pakan').set(true);
            
            // Format timestamp untuk history
            const now = new Date();
            const timestamp = `${now.getDate().toString().padStart(2, '0')}-${(now.getMonth() + 1).toString().padStart(2, '0')}-${now.getFullYear()}_${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')}`;
            
            // Catat riwayat kontrol
            await db.ref(`dashboard/history/Kontrol/${timestamp}`).set({
                action: 'Beri Pakan',
                status: 'Berhasil',
                user: '<?php echo e(Auth::user()->email); ?>'
            });
            
            showNotif('success', 'Perintah pakan dikirim!');
            
            // Reset status pakan setelah 3 detik
            setTimeout(async () => {
                await db.ref('dashboard/control/pakan').set(false);
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-broadcast"></i> Beri Pakan';
            }, 3000);
        } catch (err) {
            showNotif('danger', 'Gagal mengirim pakan: ' + err.message);
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-broadcast"></i> Beri Pakan';
        }
    };
}

// Profile Modal Scripts
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap Modal
    const profileModalEl = document.getElementById('profileModal');
    let profileModal = null;
    
    try {
        profileModal = new bootstrap.Modal(profileModalEl, {
            backdrop: false,
            keyboard: true
        });
    } catch (error) {
        console.error('Error initializing modal:', error);
    }
    
    // Get DOM elements
    const uploadTrigger = document.getElementById('uploadTrigger');
    const profileImageInput = document.getElementById('profileImageInput');
    const profileImage = document.getElementById('profileImage');
    const userDropdown = document.getElementById('userDropdown');

    // Function to clean up modal
    function cleanupModal() {
        if (profileModalEl) {
            profileModalEl.classList.remove('show');
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
        }
    }

    // Clean up modal when it's hidden
    if (profileModalEl) {
        profileModalEl.addEventListener('hidden.bs.modal', function () {
            cleanupModal();
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Pemrograman Web\smart-aquarium\resources\views/dashboard-user.blade.php ENDPATH**/ ?>