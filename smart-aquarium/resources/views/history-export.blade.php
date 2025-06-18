@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h1>Export Riwayat Data & Notifikasi</h1>
    <p>Gunakan tombol di bawah untuk mengunduh data riwayat dalam format CSV.</p>
    <div class="mb-3">
        <button class="btn btn-outline-primary" id="exportSensorBtn">Export Sensor CSV</button>
        <button class="btn btn-outline-primary" id="exportNotifBtn">Export Notifikasi CSV</button>
        <button class="btn btn-outline-primary" id="exportKontrolBtn">Export Kontrol CSV</button>
    </div>
</div>
@push('scripts')
<script>
// Fungsi untuk mengunduh CSV dari data yang diberikan
function downloadCSV(csvContent, filename) {
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    if (navigator.msSaveBlob) { // For IE 10+
        navigator.msSaveBlob(blob, filename);
    } else {
        const link = document.createElement('a');
        if (link.download !== undefined) { // feature detection
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}

// Contoh data CSV, sebaiknya data ini diambil dari backend atau Firebase
const exampleSensorCSV = "Waktu,Suhu Udara,Suhu Air,Kelembapan,Tekanan,Level Air\n2024-06-01 10:00,25.5,24.0,60,1013,50\n";
const exampleNotifCSV = "Waktu,Jenis,Judul,Pesan\n2024-06-01 10:00,info,Notifikasi Contoh,Ini adalah pesan contoh\n";
const exampleKontrolCSV = "Waktu,Aksi,Status,User\n2024-06-01 10:00,Nyalakan Pompa,Berhasil,Admin\n";

document.getElementById('exportSensorBtn').addEventListener('click', function() {
    downloadCSV(exampleSensorCSV, 'sensor_history.csv');
});
document.getElementById('exportNotifBtn').addEventListener('click', function() {
    downloadCSV(exampleNotifCSV, 'notification_history.csv');
});
document.getElementById('exportKontrolBtn').addEventListener('click', function() {
    downloadCSV(exampleKontrolCSV, 'control_history.csv');
});
</script>
@endpush
@endsection
