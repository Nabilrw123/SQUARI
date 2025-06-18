
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Header & Live Clock -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="fw-bold mb-2" style="color: #0891b2; letter-spacing: 1px;">Jadwal Otomatisasi</h1>
            <div class="live-clock-modern" style="font-size: 2rem; font-weight: 400; color: #2c3e50; display: inline-block; background: linear-gradient(90deg, #2196F3 0%, #06b6d4 100%); padding: 12px 36px; border-radius: 40px; margin-bottom: 8px;">
                <i class="fas fa-clock"></i>
                <span id="current-time"></span>
            </div>
            <div class="text-muted" style="font-size: 1.1rem;">
                <span id="current-date">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Schedules Table -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-info text-white rounded-top-3">
                    <h5 class="card-title mb-0">Daftar Jadwal</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="schedulesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                    <th>Status</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Dibuat Pada</th>
                                </tr>
                            </thead>
                            <tbody id="schedulesBody">
                                <tr><td colspan="6" class="text-center text-muted">Memuat data...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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

// Live Clock
function updateClock() {
    const now = new Date();
    document.getElementById('current-time').textContent = now.toLocaleTimeString();
    document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });
}
setInterval(updateClock, 1000); updateClock();

const schedulesBody = document.getElementById('schedulesBody');

// Render schedules in real-time
db.ref('dashboard/schedules').on('value', snap => {
    const data = snap.val() || {};
    const keys = Object.keys(data);
    if (keys.length === 0) {
        schedulesBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Belum ada jadwal.</td></tr>';
        return;
    }
    schedulesBody.innerHTML = '';
    keys.sort((a, b) => data[a].time.localeCompare(data[b].time));
    keys.forEach((id, idx) => {
        const s = data[id];
        schedulesBody.innerHTML += `
            <tr>
                <td>${idx + 1}</td>
                <td>${s.time}</td>
                <td>${formatAction(s.action)}</td>
                <td>
                    <span class="badge bg-${s.status === 'active' ? 'success' : 'secondary'}">${s.status === 'active' ? 'Aktif' : 'Nonaktif'}</span>
                </td>
                <td>${s.user || '-'}</td>
                <td>${s.created_at ? formatDate(s.created_at) : '-'}</td>
            </tr>
        `;
    });
});

function formatAction(action) {
    switch(action) {
        case 'beri_pakan': return 'Beri Pakan';
        default: return action;
    }
}

function formatDate(ts) {
    const d = new Date(ts);
    return d.toLocaleString('id-ID');
}

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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
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
    margin-bottom: 8px;
}
.live-clock-modern i {
    font-size: 2.2rem;
    margin-right: 10px;
}
@keyframes glow {
    from { box-shadow: 0 4px 24px rgba(33,150,243,0.18), 0 0 0 6px rgba(33,150,243,0.08);}
    to   { box-shadow: 0 4px 32px rgba(33,150,243,0.32), 0 0 0 12px rgba(33,150,243,0.12);}
}
.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border-radius: 1rem;
}
.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.card-header {
    border-radius: 1rem 1rem 0 0 !important;
}
.table thead th {
    background: #e0f2fe;
    color: #0f172a;
    font-weight: 600;
}
.table td, .table th {
    vertical-align: middle;
}
@media (max-width: 768px) {
    .live-clock-modern {
        font-size: 1.2rem;
        padding: 10px 18px;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\IPB\Semester 4\WEB\project v3\smart-aquarium\resources\views/schedules-user.blade.php ENDPATH**/ ?>