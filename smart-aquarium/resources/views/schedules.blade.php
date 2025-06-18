@extends('layouts.app')
@section('content')
<div class="container py-4"style="padding-left:60px;">
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

    <!-- Add/Edit Schedule Form -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white rounded-top-3">
                    <h5 class="card-title mb-0" id="form-title">Tambah Jadwal</h5>
                </div>
                <div class="card-body">
                    <form id="scheduleForm">
                        <input type="hidden" id="scheduleId">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Waktu</label>
                                <input type="time" class="form-control" id="scheduleTime" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Aksi</label>
                                <select class="form-select" id="scheduleAction" required>
                                    <option value="beri_pakan">Beri Pakan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="scheduleStatus" required>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-grid">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-plus"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="schedulesBody">
                                <tr><td colspan="7" class="text-center text-muted">Memuat data...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
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

const schedulesRef = db.ref('dashboard/schedules');
const schedulesBody = document.getElementById('schedulesBody');
const scheduleForm = document.getElementById('scheduleForm');
const scheduleIdInput = document.getElementById('scheduleId');
const scheduleTime = document.getElementById('scheduleTime');
const scheduleAction = document.getElementById('scheduleAction');
const scheduleStatus = document.getElementById('scheduleStatus');
const submitBtn = document.getElementById('submitBtn');
const formTitle = document.getElementById('form-title');

let editingId = null;

// Render schedules in real-time
db.ref('dashboard/schedules').on('value', snap => {
    const data = snap.val() || {};
    const keys = Object.keys(data);
    if (keys.length === 0) {
        schedulesBody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">Belum ada jadwal.</td></tr>';
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
                <td>
                    <button class="btn btn-sm btn-info me-1" onclick="editSchedule('${id}')"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger me-1" onclick="deleteSchedule('${id}')"><i class="fas fa-trash"></i></button>
                    <button class="btn btn-sm btn-${s.status === 'active' ? 'secondary' : 'success'}" onclick="toggleStatus('${id}', '${s.status}')">
                        <i class="fas fa-power-off"></i>
                    </button>
                </td>
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

// Add/Edit Schedule
scheduleForm.onsubmit = function(e) {
    e.preventDefault();
    submitBtn.disabled = true;
    const time = scheduleTime.value;
    const action = scheduleAction.value;
    const status = scheduleStatus.value;
    const user = window.currentUserEmail || 'anonymous';
    const now = Date.now();
    const data = { time, action, status, user, created_at: now };
    if (editingId) {
        db.ref('dashboard/schedules/' + editingId).update(data)
            .then(() => {
                showNotif('success', 'Jadwal berhasil diperbarui');
                resetForm();
            })
            .catch(err => {
                showNotif('danger', 'Gagal memperbarui jadwal: ' + err.message);
            })
            .finally(() => submitBtn.disabled = false);
    } else {
        const ref = db.ref('dashboard/schedules').push();
        ref.set(data)
            .then(() => {
                showNotif('success', 'Jadwal berhasil ditambahkan');
                resetForm();
            })
            .catch(err => {
                showNotif('danger', 'Gagal menambah jadwal: ' + err.message);
            })
            .finally(() => submitBtn.disabled = false);
    }
};

window.editSchedule = function(id) {
    db.ref('dashboard/schedules/' + id).once('value').then(snap => {
        const s = snap.val();
        if (!s) return;
        editingId = id;
        scheduleIdInput.value = id;
        scheduleTime.value = s.time;
        scheduleAction.value = s.action;
        scheduleStatus.value = s.status;
        formTitle.textContent = 'Edit Jadwal';
        submitBtn.innerHTML = '<i class="fas fa-save"></i> Update';
    });
};

function resetForm() {
    editingId = null;
    scheduleIdInput.value = '';
    scheduleTime.value = '';
    scheduleAction.value = 'beri_pakan';
    scheduleStatus.value = 'active';
    formTitle.textContent = 'Tambah Jadwal';
    submitBtn.innerHTML = '<i class="fas fa-plus"></i> Simpan';
}

window.deleteSchedule = function(id) {
    if (!confirm('Yakin ingin menghapus jadwal ini?')) return;
    db.ref('dashboard/schedules/' + id).remove()
        .then(() => {
            showNotif('success', 'Jadwal berhasil dihapus');
        })
        .catch(err => {
            showNotif('danger', 'Gagal menghapus jadwal: ' + err.message);
        });
};

window.toggleStatus = function(id, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    db.ref('dashboard/schedules/' + id + '/status').set(newStatus)
        .then(() => {
            showNotif('success', `Status jadwal diubah menjadi ${newStatus === 'active' ? 'Aktif' : 'Nonaktif'}`);
        })
        .catch(err => {
            showNotif('danger', 'Gagal mengubah status: ' + err.message);
        });
};

function showNotif(type, message) {
    const id = btoa(message).replace(/[^a-zA-Z0-9]/g, '');
    window.NotificationSystem.show(type, message, { id });
}
</script>
@endpush

@push('styles')
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
@endpush
@endsection 