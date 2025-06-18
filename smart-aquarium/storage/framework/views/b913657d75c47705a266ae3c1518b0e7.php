<?php $__env->startSection('content'); ?>
<!-- Aquarium Background -->
<div class="aquarium-bg">
    <div class="bubbles"></div>
    <div class="water-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
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
            <h4 class="mb-0">Admin Dashboard</h4>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const firebaseStatus = document.getElementById('firebaseStatus');
            if (firebaseStatus) {
                setTimeout(() => {
                    firebaseStatus.style.display = 'none';
                }, 5000); // Hide after 5 seconds
            }
        });
    </script>

    <!-- Sensor Data Cards -->
    <div class="row g-4 mb-4" style="margin-right: 10px;">
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
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-users me-2"></i> Tambah User
                    </a>
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
    :root {
        --primary: #0891b2;
        --secondary: #06b6d4;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --dark: #0f172a;
        --light: #f8fafc;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        color: #1e293b;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

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

    /* Water Particles */
    .water-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 0;
    }

    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        animation: float 20s linear infinite;
        box-shadow: 0 0 4px rgba(255, 255, 255, 0.4);
    }

    .particle:nth-child(1) { left: 5%; animation-duration: 15s; animation-delay: 0s; }
    .particle:nth-child(2) { left: 10%; animation-duration: 18s; animation-delay: 1s; }
    .particle:nth-child(3) { left: 15%; animation-duration: 12s; animation-delay: 2s; }
    .particle:nth-child(4) { left: 20%; animation-duration: 16s; animation-delay: 3s; }
    .particle:nth-child(5) { left: 25%; animation-duration: 14s; animation-delay: 4s; }
    .particle:nth-child(6) { left: 30%; animation-duration: 17s; animation-delay: 5s; }
    .particle:nth-child(7) { left: 35%; animation-duration: 13s; animation-delay: 6s; }
    .particle:nth-child(8) { left: 40%; animation-duration: 19s; animation-delay: 7s; }
    .particle:nth-child(9) { left: 45%; animation-duration: 15s; animation-delay: 8s; }
    .particle:nth-child(10) { left: 50%; animation-duration: 16s; animation-delay: 9s; }
    .particle:nth-child(11) { left: 55%; animation-duration: 14s; animation-delay: 10s; }
    .particle:nth-child(12) { left: 60%; animation-duration: 17s; animation-delay: 11s; }
    .particle:nth-child(13) { left: 65%; animation-duration: 13s; animation-delay: 12s; }
    .particle:nth-child(14) { left: 70%; animation-duration: 19s; animation-delay: 13s; }
    .particle:nth-child(15) { left: 75%; animation-duration: 15s; animation-delay: 14s; }
    .particle:nth-child(16) { left: 80%; animation-duration: 16s; animation-delay: 15s; }
    .particle:nth-child(17) { left: 85%; animation-duration: 14s; animation-delay: 16s; }
    .particle:nth-child(18) { left: 90%; animation-duration: 17s; animation-delay: 17s; }
    .particle:nth-child(19) { left: 95%; animation-duration: 13s; animation-delay: 18s; }
    .particle:nth-child(20) { left: 98%; animation-duration: 19s; animation-delay: 19s; }

    @keyframes float {
        0% {
            transform: translateY(100vh) scale(0);
            opacity: 0;
        }
        10% {
            opacity: 0.8;
            transform: translateY(90vh) scale(1);
        }
        90% {
            opacity: 0.8;
            transform: translateY(10vh) scale(1);
        }
        100% {
            transform: translateY(0) scale(0);
            opacity: 0;
        }
    }

    @keyframes bubble {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    /* Fish Styles */
    .fish {
        position: absolute;
        width: 30px;
        height: 20px;
        background-size: contain;
        background-repeat: no-repeat;
        filter: brightness(0.8);
        opacity: 0.7;
        z-index: 1;
    }

    .fish::before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background: inherit;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }

    .fish-1 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%23FFD700"/></svg>');
        animation: swim 20s linear infinite;
    }

    .fish-2 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%23FF69B4"/></svg>');
        animation: swim 25s linear infinite;
        top: 20%;
    }

    .fish-3 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%234CAF50"/></svg>');
        animation: swim 18s linear infinite;
        top: 40%;
    }

    .fish-4 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%23FF9800"/></svg>');
        animation: swim 22s linear infinite;
        top: 60%;
    }

    .fish-5 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%23E91E63"/></svg>');
        animation: swim 28s linear infinite;
        top: 80%;
    }

    .fish-6 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 50"><path d="M90,25 C90,25 70,10 50,25 C30,40 10,25 10,25 C10,25 30,40 50,25 C70,10 90,25 90,25 Z" fill="%2300BCD4"/></svg>');
        animation: swim 23s linear infinite;
        top: 30%;
    }

    @keyframes swim {
        0% {
            transform: translateX(-100%) translateY(0) rotate(0deg);
        }
        25% {
            transform: translateX(-50%) translateY(-20px) rotate(5deg);
        }
        50% {
            transform: translateX(0%) translateY(0) rotate(0deg);
        }
        75% {
            transform: translateX(50%) translateY(20px) rotate(-5deg);
        }
        100% {
            transform: translateX(100%) translateY(0) rotate(0deg);
        }
    }
    
    .main-content {
        padding: 50px;
        transition: all 0.3s;
        position: relative;
        z-index: 1;
    }
    
    .card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        overflow: hidden;
        height: 100%;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        background-color: rgba(255, 255, 255, 0.9);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 20px 25px;
        font-weight: 600;
    }
    
    .card-header .card-title {
        margin-bottom: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card.temp {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
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
    
    .control-card {
        position: relative;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 25px;
        height: 100%;
    }
    
    .control-icon {
        font-size: 2rem;
        margin-bottom: 15px;
        color: var(--primary);
    }
    
    .feed-btn {
        background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
        transition: all 0.3s;
    }
    
    .feed-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .navbar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 15px 30px;
        border-radius: 15px;
        margin-bottom: 30px;
    }
    
    .navbar-toggler {
        border: none;
        padding: 10px;
        border-radius: 8px;
        background-color: #f8fafc;
    }
    
    #firebaseStatus {
        border-radius: 50px;
        padding: 12px 25px;
        margin-bottom: 30px;
        border: none;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    .user-dropdown img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }
    
    .updated {
        animation: pulse 1s;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }
    
    .btn.active {
        opacity: 0.7;
        pointer-events: none;
    }
    
    .badge-time {
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        color: #0f172a;
    }

    /* Switch styles */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    /* Control card styles */
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

    /* Alert styles */
    .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        min-width: 300px;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Button styles */
    .btn-primary {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(33, 150, 243, 0.4);
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    }

    .btn-primary:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn-primary i {
        font-size: 1.1rem;
    }

    /* Profile Modal Styles */
    .modal {
        z-index: 1050;
    }

    .modal-backdrop {
        z-index: 1040;
    }

    .modal-content {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
        z-index: 1051;
    }

    .modal-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        color: white;
        position: relative;
        z-index: 1052;
    }

    .modal-body {
        padding: 2rem;
        position: relative;
        z-index: 1052;
    }

    .modal-footer {
        padding: 1.5rem;
        background: #f8fafc;
        position: relative;
        z-index: 1052;
    }

    .profile-container {
        max-width: 100%;
        margin: 0 auto;
    }

    .profile-header {
        margin-bottom: 2rem;
    }

    .profile-image-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 4px solid #ffffff;
        transition: all 0.3s ease;
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

    .btn-light {
        background: #f1f5f9;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
    }

    /* Animation */
    .modal.fade .modal-dialog {
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal.show .modal-content {
        animation: slideIn 0.3s ease-out;
    }

    .modal-body img {
        object-fit: cover;
        border: 3px solid #2196F3;
        box-shadow: 0 2px 8px rgba(33,150,243,0.15);
    }

    #liveClock {
        background: #2196F3;
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
        padding: 10px 28px;
        border-radius: 40px;
        box-shadow: 0 2px 8px rgba(33,150,243,0.15);
        letter-spacing: 2px;
        margin-top: 10px;
    }
    #liveClock i {
        font-size: 1.3rem;
        margin-right: 8px;
    }
    @media (max-width: 600px) {
        #liveClock {
            font-size: 1.1rem;
            padding: 7px 14px;
        }
    }

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
    @media (max-width: 600px) {
        .live-clock-modern {
            font-size: 1.2rem;
            padding: 10px 18px;
        }
        .live-clock-date {
            font-size: 0.95rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
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
let auth;

try {
    if (!firebase.apps.length) {
        app = firebase.initializeApp(firebaseConfig);
        console.log('Firebase app initialized successfully');
    } else {
        app = firebase.app();
        console.log('Using existing Firebase app');
    }
    
    db = firebase.database();
    auth = firebase.auth();
    console.log('Firebase services initialized');

    // Update Firebase connection status
    const firebaseStatus = document.getElementById('firebaseStatus');
    if (firebaseStatus) {
        firebaseStatus.className = 'alert alert-success';
        firebaseStatus.textContent = 'Terhubung ke Firebase';
        setTimeout(() => {
            firebaseStatus.style.display = 'none';
        }, 3000);
    }

    // Listen for sensor data changes
    db.ref('sensor_data').on('value', (snapshot) => {
        const data = snapshot.val();
        if (data) {
            // Update temperature
            if (data.suhu_ds18b20 !== undefined) {
                document.getElementById('suhuAir').textContent = `${data.suhu_ds18b20}°C`;
            }
            if (data.suhu_bme280 !== undefined) {
                document.getElementById('suhuBME').textContent = `${data.suhu_bme280}°C`;
            }
            // Update humidity
            if (data.kelembapan !== undefined) {
                document.getElementById('kelembaban').textContent = `${data.kelembapan}%`;
            }
            // Update pressure
            if (data.tekanan !== undefined) {
                document.getElementById('tekanan').textContent = `${data.tekanan} hPa`;
            }
            // Update water level
            if (data.level_air !== undefined) {
                document.getElementById('levelAir').textContent = `${data.level_air}%`;
            }
        }
    });

    // Listen for system status changes
    db.ref('system_status').on('value', (snapshot) => {
        const data = snapshot.val();
        if (data) {
            // Update buzzer status
            const buzzerIndicator = document.querySelector('.status-indicator');
            if (buzzerIndicator) {
                buzzerIndicator.className = `status-indicator ${data.buzzer ? 'active' : ''}`;
            }
            // Update water level thresholds
            if (data.water_level_low !== undefined) {
                document.querySelector('.col-md-4:nth-child(2) span').textContent = 
                    `Level Air Rendah: ${data.water_level_low}%`;
            }
            if (data.water_level_high !== undefined) {
                document.querySelector('.col-md-4:nth-child(3) span').textContent = 
                    `Level Air Tinggi: ${data.water_level_high}%`;
            }
        }
    });

} catch (error) {
    console.error('Error initializing Firebase:', error);
    const firebaseStatus = document.getElementById('firebaseStatus');
    if (firebaseStatus) {
        firebaseStatus.className = 'alert alert-danger';
        firebaseStatus.textContent = 'Gagal terhubung ke Firebase: ' + error.message;
    }
}

// Update clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit',
        second: '2-digit'
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

// Update clock every second
setInterval(updateClock, 1000);
updateClock(); // Initial update

// Feed Button
const pakanButton = document.getElementById('pakanButtonDashboard');
if (pakanButton) {
    pakanButton.onclick = async function() {
        try {
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

            // Format timestamp untuk history
            const now = new Date();
            const timestamp = `${now.getDate().toString().padStart(2, '0')}-${(now.getMonth() + 1).toString().padStart(2, '0')}-${now.getFullYear()}_${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')}`;

            // Jalankan update status pakan dan catat history secara paralel
            await Promise.all([
                db.ref('dashboard/control/pakan').set(true),
                db.ref(`dashboard/history/Kontrol/${timestamp}`).set({
                    action: 'Beri Pakan',
                    status: 'Berhasil',
                    user: '<?php echo e(Auth::user()->email); ?>'
                })
            ]);

            showNotif('success', '<strong>Sukses!</strong> Pakan berhasil diberikan.');

            setTimeout(async () => {
                await db.ref('dashboard/control/pakan').set(false);
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-broadcast"></i> Beri Pakan';
            }, 3000);
        } catch (err) {
            showNotif('danger', '<strong>Error!</strong> Gagal memberi pakan: ' + err.message);
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-broadcast"></i> Beri Pakan';
        }
    };
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Pemrograman Web\smart-aquarium\resources\views/dashboard.blade.php ENDPATH**/ ?>