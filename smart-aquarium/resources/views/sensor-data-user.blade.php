@extends('layouts.app')
@section('content')
<div id="notifContainer" style="position: fixed; top: 30px; right: 30px; z-index: 9999;"></div>
<div class="container py-4">
  <h2 class="mb-4">Sensor Data</h2>
  <div class="row mb-4">
    <div class="col-lg-8">
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
              <tr><td>Suhu Air (DS18B20)</td><td id="suhuAir">{{ $sensorData['suhu_ds18b20'] ?? '--' }}</td><td>°C</td></tr>
              <tr><td>Suhu Udara (BME280)</td><td id="suhuBME">{{ $sensorData['suhu_bme280'] ?? '--' }}</td><td>°C</td></tr>
              <tr><td>Kelembaban</td><td id="kelembaban">{{ $sensorData['kelembapan'] ?? '--' }}</td><td>%</td></tr>
              <tr><td>Tekanan Udara</td><td id="tekanan">{{ $sensorData['tekanan'] ?? '--' }}</td><td>hPa</td></tr>
              <tr><td>Level Air</td><td id="levelAir">{{ $sensorData['level_air'] ?? '--' }}</td><td>%</td></tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-end small text-muted">
          Terakhir update: <span id="lastUpdate">{{ $sensorData['updated_at'] ?? '-' }}</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
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
    pakanBtn.onclick = function() {
        db.ref('dashboard/control/pakan').set(true)
            .then(() => {
                showNotif('success', '<strong>Sukses!</strong> Pakan berhasil diberikan.');
                setTimeout(() => db.ref('dashboard/control/pakan').set(false), 3000);
            })
            .catch(() => {
                showNotif('danger', '<strong>Error!</strong> Gagal memberi pakan.');
            });
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
@endpush

