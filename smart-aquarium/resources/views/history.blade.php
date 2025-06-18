@extends('layouts.app')
@section('content')
<div class="container py-4"style="padding-left:60px;">
    <!-- Header & Live Clock -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="fw-bold mb-2" style="color: #0891b2; letter-spacing: 1px;">Riwayat Data & Notifikasi</h1>
            <div class="live-clock-modern" style="font-size: 2rem; font-weight: 400; color: #2c3e50; display: inline-block; background: linear-gradient(90deg, #2196F3 0%, #06b6d4 100%); padding: 12px 36px; border-radius: 40px; margin-bottom: 8px;">
                <i class="fas fa-clock"></i>
                <span id="current-time"></span>
            </div>
            <div class="text-muted" style="font-size: 1.1rem;">
                <span id="current-date">Loading...</span>
            </div>
        </div>
    </div>
    <!-- Filter & Export -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex gap-3 flex-wrap">
                <div class="form-group mb-0">
                    <label class="form-label mb-0">Rentang Waktu</label>
                    <select class="form-select" id="timeRange">
                        <option value="1h">1 Jam Terakhir</option>
                        <option value="6h">6 Jam Terakhir</option>
                        <option value="12h">12 Jam Terakhir</option>
                        <option value="24h" selected>24 Jam Terakhir</option>
                        <option value="7d">7 Hari Terakhir</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-outline-primary" id="exportBtn"><i class="bi bi-download"></i> Export CSV</button>
        </div>
    </div>
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="historyTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sensor-tab" data-bs-toggle="tab" data-bs-target="#sensor" type="button" role="tab">Sensor</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notif-tab" data-bs-toggle="tab" data-bs-target="#notif" type="button" role="tab">Notifikasi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kontrol-tab" data-bs-toggle="tab" data-bs-target="#kontrol" type="button" role="tab">Kontrol</button>
        </li>
    </ul>
    <div class="tab-content" id="historyTabsContent">
        <!-- Tab Sensor -->
        <div class="tab-pane fade show active" id="sensor" role="tabpanel">
            <div class="row g-4">
                <!-- Data Table -->
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-secondary text-white rounded-top-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Data Sensor (Tabel)</h5>
                                <button class="btn btn-danger btn-sm" onclick="deleteAllSensorData()">
                                    <i class="bi bi-trash"></i> Hapus Semua Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Suhu Udara</th>
                                            <th>Suhu Air</th>
                                            <th>Kelembapan</th>
                                            <th>Tekanan</th>
                                            <th>Level Air</th>
                                        </tr>
                                    </thead>
                                    <tr class="filter-row">
                                        <td>
                                            <input type="text" class="form-control form-control-sm" placeholder="Filter waktu" onkeyup="filterSensorTable(0, this.value)">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" placeholder="Min suhu udara" onkeyup="filterSensorTable(1, this.value, 'min')">
                                            <input type="number" class="form-control form-control-sm mt-1" placeholder="Max suhu udara" onkeyup="filterSensorTable(1, this.value, 'max')">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" placeholder="Min suhu air" onkeyup="filterSensorTable(2, this.value, 'min')">
                                            <input type="number" class="form-control form-control-sm mt-1" placeholder="Max suhu air" onkeyup="filterSensorTable(2, this.value, 'max')">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" placeholder="Min kelembapan" onkeyup="filterSensorTable(3, this.value, 'min')">
                                            <input type="number" class="form-control form-control-sm mt-1" placeholder="Max kelembapan" onkeyup="filterSensorTable(3, this.value, 'max')">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" placeholder="Min tekanan" onkeyup="filterSensorTable(4, this.value, 'min')">
                                            <input type="number" class="form-control form-control-sm mt-1" placeholder="Max tekanan" onkeyup="filterSensorTable(4, this.value, 'max')">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm" placeholder="Min level air" onkeyup="filterSensorTable(5, this.value, 'min')">
                                            <input type="number" class="form-control form-control-sm mt-1" placeholder="Max level air" onkeyup="filterSensorTable(5, this.value, 'max')">
                                        </td>
                                    </tr>
                                    <tbody id="sensorHistory">
                                        <!-- Akan diisi oleh JS -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center p-3">
                                <button id="loadMoreBtn" class="btn btn-outline-primary">Load More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Notifikasi -->
        <div class="tab-pane fade" id="notif" role="tabpanel">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-danger text-white rounded-top-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Notifikasi</h5>
                        <button class="btn btn-light btn-sm" onclick="deleteAllNotifData()">
                            <i class="bi bi-trash"></i> Hapus Semua Data
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Jenis</th>
                                    <th>Judul</th>
                                    <th>Pesan</th>
                                </tr>
                            </thead>
                            <tr class="filter-row">
                                <td>
                                    <input type="text" class="form-control form-control-sm" placeholder="Filter waktu" onkeyup="filterNotifTable(0, this.value)">
                                </td>
                                <td>
                                    <select class="form-select form-select-sm" onchange="filterNotifTable(1, this.value)">
                                        <option value="">Semua Jenis</option>
                                        <option value="warning">Warning</option>
                                        <option value="danger">Danger</option>
                                        <option value="success">Success</option>
                                        <option value="failed">Failed</option>

                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" placeholder="Filter judul" onkeyup="filterNotifTable(2, this.value)">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" placeholder="Filter pesan" onkeyup="filterNotifTable(3, this.value)">
                                </td>
                            </tr>
                            <tbody id="notifHistory">
                                <!-- Akan diisi oleh JS -->
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center p-3">
                        <button id="loadMoreNotifBtn" class="btn btn-outline-primary">Load More</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Kontrol -->
        <div class="tab-pane fade" id="kontrol" role="tabpanel">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-success text-white rounded-top-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Kontrol/Perintah</h5>
                        <button class="btn btn-light btn-sm" onclick="deleteAllKontrolData()">
                            <i class="bi bi-trash"></i> Hapus Semua Data
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                    <th>Status</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tr class="filter-row">
                                <td>
                                    <input type="text" class="form-control form-control-sm" placeholder="Filter waktu" onkeyup="filterKontrolTable(0, this.value)">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" placeholder="Filter aksi" onkeyup="filterKontrolTable(1, this.value)">
                                </td>
                                <td>
                                    <select class="form-select form-select-sm" onchange="filterKontrolTable(2, this.value)">
                                        <option value="">Semua Status</option>
                                        <option value="Berhasil">Berhasil</option>
                                        <option value="Gagal">Gagal</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" placeholder="Filter user" onkeyup="filterKontrolTable(3, this.value)">
                                </td>
                            </tr>
                            <tbody id="kontrolHistory">
                                <!-- Akan diisi oleh JS -->
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center p-3">
                        <button id="loadMoreKontrolBtn" class="btn btn-outline-primary">Load More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
.table {
    font-size: 0.98rem;
}
@media (max-width: 991px) {
    .live-clock-modern { font-size: 1.2rem; padding: 10px 18px; }
    h1 { font-size: 2rem; }
}
.filter-row {
    background-color: #f8f9fa;
}
.filter-row td {
    padding: 8px;
}
.filter-row input,
.filter-row select {
    font-size: 0.875rem;
}
</style>
@push('scripts')
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
} catch (error) {
    console.error('Error initializing Firebase:', error);
}

// Live Clock
function updateClock() {
    const now = new Date();
    document.getElementById('current-time').textContent = now.toLocaleTimeString();
    document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
setInterval(updateClock, 1000);
updateClock();

// Variables for data management
let displayedItems = 10;
let allSensorData = [];
let displayedNotifItems = 10;
let allNotifData = [];
let displayedKontrolItems = 10;
let allKontrolData = [];

// Add these variables at the top of the script section, after the Firebase initialization
let currentSensorFilters = {
    time: '',
    minValues: {},
    maxValues: {}
};
let currentNotifFilters = {
    time: '',
    type: '',
    title: '',
    message: ''
};
let currentKontrolFilters = {
    time: '',
    action: '',
    status: '',
    user: ''
};

// Function to parse timestamp
function parseTimestamp(timestamp) {
    if (!timestamp || !timestamp.includes('_')) return null;
    const [datePart, timePart] = timestamp.split('_');
    if (!datePart || !timePart) return null;
    const [day, month, year] = datePart.split('-');
    const [hours, minutes, seconds] = timePart.split(':');
    if (!day || !month || !year || !hours || !minutes || !seconds) return null;
    return new Date(year, month - 1, day, hours, minutes, seconds);
}

// Tab functions
function updateSensorTab() {
    if (!db) {
        console.error('Firebase database not initialized');
        return;
    }
    
    console.log('Fetching sensor data...');
    db.ref('dashboard/history/sensor').on('value', snapshot => {
        const data = snapshot.val();
        console.log('Raw sensor data:', data);
        
        if (!data) {
            console.log('No data received from Firebase');
            return;
        }

        // Process data for table
        allSensorData = Object.entries(data)
            .map(([timestamp, values]) => {
                const date = parseTimestamp(timestamp);
                if (!date) return null;
                
                return {
                    waktu: timestamp,
                    suhu_bme280: parseFloat(values.suhu_bme280) || 0,
                    suhu_ds18b20: parseFloat(values.suhu_ds18b20) || 0,
                    kelembapan: parseFloat(values.kelembapan) || 0,
                    tekanan: parseFloat(values.tekanan) || 0,
                    level_air: parseFloat(values.level_air) || 0
                };
            })
            .filter(Boolean)
            .sort((a, b) => parseTimestamp(b.waktu) - parseTimestamp(a.waktu));

        // Update table
        updateSensorTable(allSensorData);
    }, error => {
        console.error('Error fetching sensor data:', error);
    });
}

function updateNotifTab() {
    if (!db) {
        console.error('Firebase database not initialized');
        return;
    }
    
    console.log('Fetching notification data...');
    db.ref('dashboard/history/notifikasi').on('value', snapshot => {
        const data = snapshot.val();
        console.log('Raw notification data:', data);
        
        if (!data) {
            console.log('No data received from Firebase');
            return;
        }

        // Process and store all notification data
        allNotifData = Object.entries(data)
            .map(([timestamp, item]) => {
                const date = parseTimestamp(timestamp);
                if (!date) return null;
                
                return {
                    timestamp,
                    date,
                    item
                };
            })
            .sort((a, b) => b.date - a.date);

        // Reset displayed items
        displayedNotifItems = 10;
        
        // Update notification table
        updateNotifTable();
    }, error => {
        console.error('Error fetching notification data:', error);
    });
}

function updateKontrolTab() {
    if (!db) {
        console.error('Firebase database not initialized');
        return;
    }
    
    console.log('Fetching control data...');
    db.ref('dashboard/history/Kontrol').on('value', snapshot => {
        const data = snapshot.val();
        console.log('Raw control data:', data);
        
        if (!data) {
            console.log('No data received from Firebase');
            return;
        }

        // Process and store all control data
        allKontrolData = Object.entries(data)
            .map(([timestamp, item]) => {
                const date = parseTimestamp(timestamp);
                if (!date) return null;
                
                return {
                    timestamp,
                    date,
                    action: item.action || item.aksi || '--',
                    status: item.status || item.status_aksi || '--',
                    user: item.user || item.pengguna || '--'
                };
            })
            .sort((a, b) => b.date - a.date);

        // Reset displayed items
        displayedKontrolItems = 10;
        
        // Update control table
        updateKontrolTable();
    }, error => {
        console.error('Error fetching control data:', error);
    });
}

// Table update functions
function updateSensorTable(sensorData) {
    const tbody = document.getElementById('sensorHistory');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    const itemsToShow = sensorData.slice(0, displayedItems);
    
    itemsToShow.forEach(item => {
        try {
            const date = parseTimestamp(item.waktu);
            if (!date) return;
            const formattedDate = date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${formattedDate}</td>
                <td>${item.suhu_bme280.toFixed(1)}</td>
                <td>${item.suhu_ds18b20.toFixed(1)}</td>
                <td>${item.kelembapan.toFixed(1)}</td>
                <td>${item.tekanan.toFixed(1)}</td>
                <td>${item.level_air.toFixed(1)}</td>
            `;
            tbody.appendChild(row);
        } catch (error) {
            console.error('Error processing row:', error, item);
        }
    });

    // Apply current filters after updating the table
    applySensorFilters();

    // Show/hide load more button
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.style.display = displayedItems >= sensorData.length ? 'none' : 'inline-block';
    }
}

function updateNotifTable() {
    const tbody = document.getElementById('notifHistory');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    const itemsToShow = allNotifData.slice(0, displayedNotifItems);
    
    itemsToShow.forEach(item => {
        try {
            const formattedDate = item.date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${formattedDate}</td>
                <td>
                    <span class="badge bg-${item.item.type === 'danger' ? 'danger' : (item.item.type === 'warning' ? 'warning' : 'success')}">
                        ${item.item.type}
                    </span>
                </td>
                <td>${item.item.title || '--'}</td>
                <td>${item.item.message || '--'}</td>
            `;
            tbody.appendChild(row);
        } catch (error) {
            console.error('Error processing notification row:', error, item);
        }
    });

    // Apply current filters after updating the table
    applyNotifFilters();

    // Show/hide load more button
    const loadMoreBtn = document.getElementById('loadMoreNotifBtn');
    if (loadMoreBtn) {
        loadMoreBtn.style.display = displayedNotifItems >= allNotifData.length ? 'none' : 'inline-block';
    }
}

function updateKontrolTable() {
    const tbody = document.getElementById('kontrolHistory');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    const itemsToShow = allKontrolData.slice(0, displayedKontrolItems);
    
    itemsToShow.forEach(item => {
        try {
            const formattedDate = item.date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${formattedDate}</td>
                <td>
                    <span class="badge bg-${getActionColor(item.action)}">
                        ${item.action}
                    </span>
                </td>
                <td>
                    <span class="badge bg-${getStatusColor(item.status)}">
                        ${item.status}
                    </span>
                </td>
                <td>${item.user}</td>
            `;
            tbody.appendChild(row);
        } catch (error) {
            console.error('Error processing control row:', error, item);
        }
    });

    // Apply current filters after updating the table
    applyKontrolFilters();

    // Show/hide load more button
    const loadMoreBtn = document.getElementById('loadMoreKontrolBtn');
    if (loadMoreBtn) {
        loadMoreBtn.style.display = displayedKontrolItems >= allKontrolData.length ? 'none' : 'inline-block';
    }
}

// Helper functions
function getActionColor(action) {
    if (!action || action === '--') return 'secondary';
    action = action.toLowerCase();
    if (action.includes('on') || action.includes('nyala')) return 'success';
    if (action.includes('off') || action.includes('mati')) return 'danger';
    if (action.includes('auto') || action.includes('otomatis')) return 'info';
    return 'primary';
}

function getStatusColor(status) {
    if (!status || status === '--') return 'secondary';
    status = status.toLowerCase();
    if (status.includes('success') || status.includes('berhasil')) return 'success';
    if (status.includes('failed') || status.includes('gagal')) return 'danger';
    if (status.includes('pending') || status.includes('menunggu')) return 'warning';
    return 'info';
}

// Delete functions
function deleteAllSensorData() {
    if (!db) {
        console.error('Firebase database not initialized');
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin menghapus semua data sensor? Tindakan ini tidak dapat dibatalkan.')) {
        db.ref('dashboard/history/sensor').remove()
            .then(() => {
                alert('Semua data sensor berhasil dihapus');
                updateSensorTab();
            })
            .catch((error) => {
                console.error('Error deleting sensor data:', error);
                alert('Gagal menghapus data sensor');
            });
    }
}

function deleteAllNotifData() {
    if (!db) {
        console.error('Firebase database not initialized');
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin menghapus semua data notifikasi? Tindakan ini tidak dapat dibatalkan.')) {
        db.ref('dashboard/history/notifikasi').remove()
            .then(() => {
                alert('Semua data notifikasi berhasil dihapus');
                updateNotifTab();
            })
            .catch((error) => {
                console.error('Error deleting notification data:', error);
                alert('Gagal menghapus data notifikasi');
            });
    }
}

function deleteAllKontrolData() {
    if (!db) {
        console.error('Firebase database not initialized');
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin menghapus semua data kontrol? Tindakan ini tidak dapat dibatalkan.')) {
        db.ref('dashboard/history/Kontrol').remove()
            .then(() => {
                alert('Semua data kontrol berhasil dihapus');
                updateKontrolTab();
            })
            .catch((error) => {
                console.error('Error deleting control data:', error);
                alert('Gagal menghapus data kontrol');
            });
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Load more buttons
    document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
        displayedItems += 10;
        updateSensorTable(allSensorData);
    });

    document.getElementById('loadMoreNotifBtn')?.addEventListener('click', function() {
        displayedNotifItems += 10;
        updateNotifTable();
    });

    document.getElementById('loadMoreKontrolBtn')?.addEventListener('click', function() {
        displayedKontrolItems += 10;
        updateKontrolTable();
    });

    // Tab switching
    document.getElementById('sensor-tab')?.addEventListener('shown.bs.tab', updateSensorTab);
    document.getElementById('notif-tab')?.addEventListener('shown.bs.tab', updateNotifTab);
    document.getElementById('kontrol-tab')?.addEventListener('shown.bs.tab', updateKontrolTab);

    // Initial load
    updateSensorTab();

    // Export CSV button click handler
    document.getElementById('exportBtn')?.addEventListener('click', function() {
        const activeTab = document.querySelector('.nav-link.active')?.id;
        let type = '';

        if (activeTab === 'sensor-tab') {
            type = 'sensor';
        } else if (activeTab === 'notif-tab') {
            type = 'notif';
        } else if (activeTab === 'kontrol-tab') {
            type = 'kontrol';
        } else {
            alert('Tab tidak dikenali untuk ekspor.');
            return;
        }

        const url = `/history/export?type=${type}`;
        window.location.href = url;
    });
});

// Filter functions
function filterSensorTable(columnIndex, value, type = '') {
    if (type === 'min') {
        currentSensorFilters.minValues[columnIndex] = value;
    } else if (type === 'max') {
        currentSensorFilters.maxValues[columnIndex] = value;
    } else {
        currentSensorFilters.time = value;
    }
    applySensorFilters();
}

function filterNotifTable(columnIndex, value) {
    switch(columnIndex) {
        case 0: currentNotifFilters.time = value; break;
        case 1: currentNotifFilters.type = value; break;
        case 2: currentNotifFilters.title = value; break;
        case 3: currentNotifFilters.message = value; break;
    }
    applyNotifFilters();
}

function filterKontrolTable(columnIndex, value) {
    switch(columnIndex) {
        case 0: currentKontrolFilters.time = value; break;
        case 1: currentKontrolFilters.action = value; break;
        case 2: currentKontrolFilters.status = value; break;
        case 3: currentKontrolFilters.user = value; break;
    }
    applyKontrolFilters();
}

// Add these new filter application functions
function applySensorFilters() {
    const table = document.getElementById('sensorHistory');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let show = true;

        // Apply time filter
        if (currentSensorFilters.time) {
            const timeCell = cells[0].textContent || cells[0].innerText;
            if (!timeCell.toLowerCase().includes(currentSensorFilters.time.toLowerCase())) {
                show = false;
            }
        }

        // Apply numeric filters
        for (let col = 1; col < cells.length; col++) {
            const cellValue = parseFloat(cells[col].textContent || cells[col].innerText);
            const minValue = currentSensorFilters.minValues[col];
            const maxValue = currentSensorFilters.maxValues[col];

            if (minValue && cellValue < parseFloat(minValue)) {
                show = false;
            }
            if (maxValue && cellValue > parseFloat(maxValue)) {
                show = false;
            }
        }

        row.style.display = show ? '' : 'none';
    }
}

function applyNotifFilters() {
    const table = document.getElementById('notifHistory');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let show = true;

        // Apply all filters
        if (currentNotifFilters.time && !cells[0].textContent.toLowerCase().includes(currentNotifFilters.time.toLowerCase())) {
            show = false;
        }
        if (currentNotifFilters.type && !cells[1].textContent.toLowerCase().includes(currentNotifFilters.type.toLowerCase())) {
            show = false;
        }
        if (currentNotifFilters.title && !cells[2].textContent.toLowerCase().includes(currentNotifFilters.title.toLowerCase())) {
            show = false;
        }
        if (currentNotifFilters.message && !cells[3].textContent.toLowerCase().includes(currentNotifFilters.message.toLowerCase())) {
            show = false;
        }

        row.style.display = show ? '' : 'none';
    }
}

function applyKontrolFilters() {
    const table = document.getElementById('kontrolHistory');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let show = true;

        // Apply all filters
        if (currentKontrolFilters.time && !cells[0].textContent.toLowerCase().includes(currentKontrolFilters.time.toLowerCase())) {
            show = false;
        }
        if (currentKontrolFilters.action && !cells[1].textContent.toLowerCase().includes(currentKontrolFilters.action.toLowerCase())) {
            show = false;
        }
        if (currentKontrolFilters.status && !cells[2].textContent.toLowerCase().includes(currentKontrolFilters.status.toLowerCase())) {
            show = false;
        }
        if (currentKontrolFilters.user && !cells[3].textContent.toLowerCase().includes(currentKontrolFilters.user.toLowerCase())) {
            show = false;
        }

        row.style.display = show ? '' : 'none';
    }
}
</script>
@endpush
@endsection