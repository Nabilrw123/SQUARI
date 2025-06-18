<?php $__env->startSection('content'); ?>
<div id="notifContainer" style="position: fixed; top: 30px; right: 30px; z-index: 9999;"></div>
<div id="notification-container" style="position: fixed; top: 30px; right: 30px; z-index: 9999;"></div>
<div class="container py-4">
  <!-- Header & Live Clock -->
  <div class="row mb-4">
    <div class="col-12 text-center">
      <h1 class="fw-bold mb-2" style="color: #0891b2; letter-spacing: 1px;">Controls</h1>
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
  <div class="row g-4 justify-content-center">
    <div class="col-md-5">
      <div class="card text-center mb-4">
        <div class="card-header bg-warning text-white">Pakan Ikan</div>
        <div class="card-body">
          <button id="pakanBtn" class="btn btn-lg btn-outline-warning">Beri Pakan</button>
        </div>
      </div>
      <!-- Kontrol Rentang Sensor -->
      <div class="card text-center">
        <div class="card-header bg-primary text-white">Kontrol Rentang Sensor</div>
        <div class="card-body">
          <form id="rangeForm">
            <div class="row mb-2">
              <div class="col-6">
                <label class="form-label">Suhu Udara Min (°C)</label>
                <input type="number" step="0.1" class="form-control" id="suhuUdaraMin">
              </div>
              <div class="col-6">
                <label class="form-label">Suhu Udara Max (°C)</label>
                <input type="number" step="0.1" class="form-control" id="suhuUdaraMax">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-6">
                <label class="form-label">Suhu Air Min (°C)</label>
                <input type="number" step="0.1" class="form-control" id="suhuAirMin">
              </div>
              <div class="col-6">
                <label class="form-label">Suhu Air Max (°C)</label>
                <input type="number" step="0.1" class="form-control" id="suhuAirMax">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-6">
                <label class="form-label">Level Air Low (%)</label>
                <input type="number" class="form-control" id="levelAirLow">
              </div>
              <div class="col-6">
                <label class="form-label">Level Air High (%)</label>
                <input type="number" class="form-control" id="levelAirHigh">
              </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2 w-100">Simpan Rentang</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card text-center">
        <div class="card-header bg-info text-white">Status Buzzer</div>
        <div class="card-body">
          <span class="badge bg-secondary" id="buzzerStatus">--</span>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

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
.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 15px 25px;
  border-radius: 12px;
  color: white;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transform: translateX(120%);
  transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  z-index: 9999;
  max-width: 350px;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
}
.notification.show { 
  transform: translateX(0);
  animation: slideIn 0.3s ease-out;
}
.notification.success { 
  background: linear-gradient(135deg, #00b09b, #96c93d);
  border-left: 4px solid #96c93d;
}
.notification.danger { 
  background: linear-gradient(135deg, #ff416c, #ff4b2b);
  border-left: 4px solid #ff4b2b;
}
.notification.warning { 
  background: linear-gradient(135deg, #f7971e, #ffd200);
  border-left: 4px solid #ffd200;
}
.notification.info { 
  background: linear-gradient(135deg, #2193b0, #6dd5ed);
  border-left: 4px solid #6dd5ed;
}
.notification i { 
  font-size: 1.5rem;
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}
.notification-content { 
  flex: 1;
}
.notification-title { 
  font-weight: 600; 
  margin-bottom: 4px;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
.notification-message { 
  font-size: 0.9rem; 
  opacity: 0.95;
  text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
@keyframes slideIn {
  from {
    transform: translateX(120%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}
@keyframes pulse { 
  0% { transform: scale(1); } 
  50% { transform: scale(1.02); } 
  100% { transform: scale(1); }
}
.notification.pulse { 
  animation: pulse 1s infinite;
}
</style>
<?php $__env->stopPush(); ?>

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

// Jam realtime
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

// Notifikasi
function showNotif(type, message) {
    const notif = document.createElement('div');
    notif.className = `notification ${type}`;
    notif.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <div class="notification-content">
            <div class="notification-message">${message}</div>
        </div>
    `;
    document.getElementById('notifContainer').appendChild(notif);
    setTimeout(() => notif.classList.add('show'), 100);
    setTimeout(() => {
        notif.classList.remove('show');
        setTimeout(() => notif.remove(), 300);
    }, 3000);
}

// Listen status buzzer secara realtime
const buzzerStatus = document.getElementById('buzzerStatus');
db.ref('dashboard/status/buzzer').on('value', snap => {
    const isActive = snap.val();
    if (isActive) {
        buzzerStatus.textContent = 'Aktif';
        buzzerStatus.className = 'badge bg-success';
    } else {
        buzzerStatus.textContent = 'Nonaktif';
        buzzerStatus.className = 'badge bg-secondary';
    }
});

// Tombol pakan realtime + notifikasi
const pakanBtn = document.getElementById('pakanBtn');
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
        
        showNotif('success', 'Perintah pakan dikirim!');
        
        // Reset status pakan setelah 3 detik
        setTimeout(async () => {
            await db.ref('dashboard/control/pakan').set(false);
            this.disabled = false;
            this.innerHTML = 'Beri Pakan';
        }, 3000);
    } catch (err) {
        showNotif('danger', 'Gagal mengirim pakan: ' + err.message);
        this.disabled = false;
        this.innerHTML = 'Beri Pakan';
    }
};

// Kontrol rentang sensor
const statusRef = db.ref('dashboard/status');
const rangeForm = document.getElementById('rangeForm');
const suhuUdaraMin = document.getElementById('suhuUdaraMin');
const suhuUdaraMax = document.getElementById('suhuUdaraMax');
const suhuAirMin = document.getElementById('suhuAirMin');
const suhuAirMax = document.getElementById('suhuAirMax');
const levelAirLow = document.getElementById('levelAirLow');
const levelAirHigh = document.getElementById('levelAirHigh');

// Load nilai rentang saat ini
statusRef.on('value', snap => {
    const data = snap.val() || {};
    suhuUdaraMin.value = data.suhu_udara_min ?? '';
    suhuUdaraMax.value = data.suhu_udara_max ?? '';
    suhuAirMin.value = data.suhu_air_min ?? '';
    suhuAirMax.value = data.suhu_air_max ?? '';
    levelAirLow.value = data.water_level_low ?? '';
    levelAirHigh.value = data.water_level_high ?? '';
});

// Simpan rentang ke Firebase
rangeForm.onsubmit = async function(e) {
    e.preventDefault();
    try {
        const updates = {
            suhu_udara_min: parseFloat(suhuUdaraMin.value),
            suhu_udara_max: parseFloat(suhuUdaraMax.value),
            suhu_air_min: parseFloat(suhuAirMin.value),
            suhu_air_max: parseFloat(suhuAirMax.value),
            water_level_low: parseInt(levelAirLow.value),
            water_level_high: parseInt(levelAirHigh.value)
        };

        // Update rentang di Firebase
        await statusRef.update(updates);

        // Format timestamp untuk history
        const now = new Date();
        const timestamp = `${now.getDate().toString().padStart(2, '0')}-${(now.getMonth() + 1).toString().padStart(2, '0')}-${now.getFullYear()}_${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}:${now.getSeconds().toString().padStart(2, '0')}`;

        // Catat riwayat kontrol
        await db.ref(`dashboard/history/Kontrol/${timestamp}`).set({
            action: 'Update Rentang Sensor',
            status: 'Berhasil',
            user: '<?php echo e(Auth::user()->email); ?>'
        });

        showNotif('success', 'Rentang sensor berhasil disimpan!');
    } catch (err) {
        showNotif('danger', 'Gagal menyimpan rentang: ' + err.message);
    }
};
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\IPB\Semester 4\WEB\project v3\smart-aquarium\resources\views/controls.blade.php ENDPATH**/ ?>