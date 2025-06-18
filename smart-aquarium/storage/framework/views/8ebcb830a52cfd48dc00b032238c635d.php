<?php $__env->startSection('content'); ?>
<div class="container py-4">
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
                <!-- Individual Sensor Charts -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-header bg-danger text-white rounded-top-3">
                            <h5 class="mb-0">Suhu Udara</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="airTempChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-header bg-info text-white rounded-top-3">
                            <h5 class="mb-0">Suhu Air</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="waterTempChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-header bg-success text-white rounded-top-3">
                            <h5 class="mb-0">Kelembapan</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="humidityChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-header bg-warning text-white rounded-top-3">
                            <h5 class="mb-0">Tekanan</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pressureChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-header bg-primary text-white rounded-top-3">
                            <h5 class="mb-0">Level Air</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="waterLevelChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

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
</style>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
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

// Chart configuration
const chartConfig = {
    type: 'line',
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 0
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'dd/MM/yyyy HH:mm'
                    },
                    tooltipFormat: 'dd/MM/yyyy HH:mm'
                },
                ticks: {
                    maxRotation: 45,
                    minRotation: 45,
                    autoSkip: true,
                    maxTicksLimit: 8
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: false,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(context) {
                        return `${context.dataset.label}: ${context.parsed.y.toFixed(1)}`;
                    }
                }
            }
        }
    }
};

// Initialize charts
const airTempChart = new Chart(
    document.getElementById('airTempChart'),
    {
        ...chartConfig,
        data: {
            datasets: [{
                label: 'Suhu Udara (°C)',
                data: [],
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    }
);

const waterTempChart = new Chart(
    document.getElementById('waterTempChart'),
    {
        ...chartConfig,
        data: {
            datasets: [{
                label: 'Suhu Air (°C)',
                data: [],
                borderColor: '#0dcaf0',
                backgroundColor: 'rgba(13, 202, 240, 0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    }
);

const humidityChart = new Chart(
    document.getElementById('humidityChart'),
    {
        ...chartConfig,
        data: {
            datasets: [{
                label: 'Kelembapan (%)',
                data: [],
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    }
);

const pressureChart = new Chart(
    document.getElementById('pressureChart'),
    {
        ...chartConfig,
        data: {
            datasets: [{
                label: 'Tekanan (hPa)',
                data: [],
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    }
);

const waterLevelChart = new Chart(
    document.getElementById('waterLevelChart'),
    {
        ...chartConfig,
        data: {
            datasets: [{
                label: 'Level Air (%)',
                data: [],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    }
);

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

// Function to update chart data
function updateChartData(chart, data) {
    try {
        const chartData = data.map(item => ({
            x: parseTimestamp(item.waktu),
            y: item.value
        })).filter(item => !isNaN(item.y));

        // Sort data by timestamp
        chartData.sort((a, b) => a.x - b.x);

        // Update chart
        chart.data.datasets[0].data = chartData;
        chart.update('none');
    } catch (error) {
        console.error('Error updating chart:', error);
    }
}

// Listen for sensor data changes
db.ref('dashboard/history/sensor').on('value', (snapshot) => {
    try {
        const data = snapshot.val() || {};
        console.log('Raw sensor data:', data); // Debug log

        // Process data for charts and table
        const dataArr = Object.entries(data)
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
            .filter(Boolean) // hanya data yang valid
            .sort((a, b) => parseTimestamp(a.waktu) - parseTimestamp(b.waktu));

        console.log('Processed sensor data:', dataArr); // Debug log

        // Update each chart with proper data mapping
        updateChartData(airTempChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.suhu_bme280
        })));

        updateChartData(waterTempChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.suhu_ds18b20
        })));

        updateChartData(humidityChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.kelembapan
        })));

        updateChartData(pressureChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.tekanan
        })));

        updateChartData(waterLevelChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.level_air
        })));

        // Update table
        allSensorData = dataArr;
        updateSensorTable(allSensorData);
    } catch (error) {
        console.error('Error processing sensor data:', error);
    }
});

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

        // Process data for charts
        const dataArr = Object.entries(data)
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
            .sort((a, b) => parseTimestamp(a.waktu) - parseTimestamp(b.waktu));

        // Update all charts
        updateChartData(airTempChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.suhu_bme280
        })));
        updateChartData(waterTempChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.suhu_ds18b20
        })));
        updateChartData(humidityChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.kelembapan
        })));
        updateChartData(pressureChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.tekanan
        })));
        updateChartData(waterLevelChart, dataArr.map(item => ({
            waktu: item.waktu,
            value: item.level_air
        })));

        // Process and store all data for table
        allSensorData = dataArr;
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
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Pemrograman Web\smart-aquarium\resources\views/history.blade.php ENDPATH**/ ?>