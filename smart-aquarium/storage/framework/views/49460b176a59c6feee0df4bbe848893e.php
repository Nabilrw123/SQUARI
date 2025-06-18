<?php $__env->startSection('content'); ?>
<div id="notifContainer" style="position: fixed; top: 30px; right: 30px; z-index: 9999;"></div>
<div class="container py-4" style="padding-left:60px;">
  <!-- Header & Live Clock -->
  <div class="row mb-4">
    <div class="col-12 text-center">
      <h1 class="fw-bold mb-2" style="color: #0891b2; letter-spacing: 1px;">Sensor Data</h1>
      <div class="live-clock-modern" style="font-size: 2rem; font-weight: 400; color: #2c3e50; display: inline-block; background: linear-gradient(90deg, #2196F3 0%, #06b6d4 100%); padding: 12px 36px; border-radius: 40px; margin-bottom: 8px;">
        <i class="fas fa-clock"></i>
        <span id="current-time"></span>
      </div>
      <div class="text-muted" style="font-size: 1.1rem;">
        <span id="current-date">Loading...</span>
      </div>
    </div>
  </div>
  <!-- END Header & Live Clock -->

  <!-- Current Sensor Data -->
  <div class="row mb-4">
    <div class="col-lg-8 mx-auto">
      <div class="card mb-3">
        <div class="card-header bg-primary text-white">
          Data Sensor Terbaru
        </div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>Sensor</th>
                <th>Nilai</th>
                <th>Satuan</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>Suhu Air (DS18B20)</td><td id="suhuAir"><?php echo e($sensorData['suhu_ds18b20'] ?? '--'); ?></td><td>°C</td></tr>
              <tr><td>Suhu Udara (BME280)</td><td id="suhuBME"><?php echo e($sensorData['suhu_bme280'] ?? '--'); ?></td><td>°C</td></tr>
              <tr><td>Kelembaban</td><td id="kelembaban"><?php echo e($sensorData['kelembapan'] ?? '--'); ?></td><td>%</td></tr>
              <tr><td>Tekanan Udara</td><td id="tekanan"><?php echo e($sensorData['tekanan'] ?? '--'); ?></td><td>hPa</td></tr>
              <tr><td>Level Air</td><td id="levelAir"><?php echo e($sensorData['level_air'] ?? '--'); ?></td><td>%</td></tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-end small text-muted">
          Terakhir update: <span id="lastUpdate"><?php echo e($sensorData['updated_at'] ?? '-'); ?></span>
        </div>
      </div>
    </div>
  </div>

  <!-- Sensor Charts -->
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
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
<script>
// Inisialisasi Firebase
const firebaseConfig = {
    apiKey: "AIzaSyC6zxY_ljbhoQEMbZYHuDRNZ2GGUbswQes",
    authDomain: "smart-aquarium-3720d.firebaseapp.com",
    databaseURL: "https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "smart-aquarium-3720d",
    storageBucket: "smart-aquarium-3720d.firebasestorage.app",
    messagingSenderId: "135942126154",
    appId: "1:135942126154:web:8e4a38acbf4b5acddfc4b3"
};
if (typeof firebase === 'undefined' || !firebase.apps || !firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
}
const db = firebase.database();

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
        console.log('Raw sensor data:', data);

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
    } catch (error) {
        console.error('Error processing sensor data:', error);
    }
});

// Fungsi untuk mengupdate tabel sensor
function updateSensorTable(data) {
    const formatValue = (value) => {
        if (value === undefined || value === null) return '--';
        return parseFloat(value).toFixed(1);
    };

    document.querySelector('#suhuAir').textContent = formatValue(data.suhu_ds18b20);
    document.querySelector('#suhuBME').textContent = formatValue(data.suhu_bme280);
    document.querySelector('#kelembaban').textContent = formatValue(data.kelembapan);
    document.querySelector('#tekanan').textContent = formatValue(data.tekanan);
    document.querySelector('#levelAir').textContent = formatValue(data.level_air);
    document.querySelector('#lastUpdate').textContent = new Date().toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
}

// Listen untuk perubahan data sensor
db.ref('dashboard/sensor').on('value', snapshot => {
    const data = snapshot.val() || {};
    updateSensorTable(data);
});

function showNotif(type, message) {
    const notif = document.createElement('div');
    notif.className = `alert alert-${type} alert-dismissible fade show`;
    notif.style.minWidth = '250px';
    notif.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.getElementById('notifContainer').appendChild(notif);
    setTimeout(() => {
        notif.classList.remove('show');
        notif.classList.add('hide');
        setTimeout(() => notif.remove(), 500);
    }, 3000);
}

const pakanBtn = document.getElementById('pakanBtn');
if (pakanBtn) {
    pakanBtn.onclick = async function() {
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
            
            showNotif('success', '<strong>Sukses!</strong> Pakan berhasil diberikan.');
            
            // Reset status pakan setelah 3 detik
            setTimeout(async () => {
                await db.ref('dashboard/control/pakan').set(false);
                this.disabled = false;
                this.innerHTML = 'Beri Pakan';
            }, 3000);
        } catch (err) {
            showNotif('danger', '<strong>Error!</strong> Gagal memberi pakan: ' + err.message);
            this.disabled = false;
            this.innerHTML = 'Beri Pakan';
        }
    };
}

db.ref('dashboard/status/buzzer').on('value', snap => {
    const isActive = snap.val();
    if (isActive) {
        showNotif('warning', '<strong>Perhatian!</strong> Buzzer aktif: Level air tidak normal.');
    }
    // ...update badge seperti sebelumnya...
});

// Tambahkan script live clock
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
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\IPB\Semester 4\WEB\project v3\smart-aquarium\resources\views/sensor-data.blade.php ENDPATH**/ ?>