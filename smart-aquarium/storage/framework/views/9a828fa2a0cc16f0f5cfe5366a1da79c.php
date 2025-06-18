<?php $__env->startSection('content'); ?>
<div id="notifContainer" style="position: fixed; top: 30px; right: 30px; z-index: 9999;"></div>
<div class="container py-4">
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
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Pemrograman Web\smart-aquarium\resources\views/sensor-data.blade.php ENDPATH**/ ?>