<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Smart Aquarium</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
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
            </div>
            <div class="fish fish-1"></div>
            <div class="fish fish-2"></div>
            <div class="fish fish-3"></div>
            <div class="fish fish-4"></div>
            <div class="fish fish-5"></div>
            <div class="fish fish-6"></div>
        </div>

        <div class="welcome-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="welcome-card">
                            <div class="welcome-header">
                                <div class="header-content">
                                    <h1>Smart Aquarium</h1>
                                    <p>Monitor dan kendalikan akuarium Anda dengan mudah</p>
                                </div>
                                <div class="header-image">
                                    <img src="<?php echo e(asset('storage/profile/default-profile.png')); ?>" alt="Profile Icon" class="img-fluid" /> 
                                </div>

                            </div>
                            <div class="welcome-body">
                                <div class="row g-4 mb-5">
                                    <div class="col-md-4">
                                        <div class="stat-card temp" data-bs-toggle="modal" data-bs-target="#tempModal" style="cursor: pointer;">
                                            <div class="stat-content">
                                                <div class="stat-icon">
                                                    <i class="fas fa-temperature-high"></i>
                                                </div>
                                                <div class="stat-info">
                                                    <div class="stat-value" id="suhuAir"><?php echo e($sensorData['suhu_ds18b20'] ?? '--'); ?>°C</div>
                                                    <div class="stat-label">Suhu Air</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="stat-card level" data-bs-toggle="modal" data-bs-target="#levelModal" style="cursor: pointer;">
                                            <div class="stat-content">
                                                <div class="stat-icon">
                                                    <i class="fas fa-water"></i>
                                                </div>
                                                <div class="stat-info">
                                                    <div class="stat-value" id="levelAir"><?php echo e($sensorData['level_air'] ?? '--'); ?>%</div>
                                                    <div class="stat-label">Level Air</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="stat-card quality" data-bs-toggle="modal" data-bs-target="#qualityModal" style="cursor: pointer;">
                                            <div class="stat-content">
                                                <div class="stat-icon">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div class="stat-info">
                                                    <div class="stat-value" id="kelembaban"><?php echo e($sensorData['kelembapan'] ?? '--'); ?>%</div>
                                                    <div class="stat-label">Kelembaban</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="features-section">
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <div class="feature-card">
                                                <i class="fas fa-chart-line"></i>
                                                <h3>Monitoring Real-time</h3>
                                                <p>Pantau kondisi akuarium Anda secara real-time dengan analisis detail</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="feature-card">
                                                <i class="fas fa-robot"></i>
                                                <h3>Otomatisasi Pintar</h3>
                                                <p>Otomatisasi pemberian pakan, pencahayaan, dan filtrasi air dengan kontrol pintar</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="feature-card">
                                                <i class="fas fa-bell"></i>
                                                <h3>Notifikasi Pintar</h3>
                                                <p>Dapatkan notifikasi instan tentang perubahan penting di akuarium Anda</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i>
                                        Masuk ke Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Temperature Modal -->
        <div class="modal fade" id="tempModal" tabindex="-1" aria-labelledby="tempModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tempModalLabel">Detail Suhu Air</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="current-temp">
                                    <h3>Suhu Saat Ini</h3>
                                    <div class="temp-value"><?php echo e($sensorData['suhu_ds18b20'] ? number_format($sensorData['suhu_ds18b20'], 1) : '--'); ?>°C</div>
                                    <div class="temp-trend up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>0.5°C dari jam sebelumnya</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="temp-stats">
                                    <div class="stat-item">
                                        <span class="label">Min (24 jam)</span>
                                        <span class="value" id="minTemp">--</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="label">Max (24 jam)</span>
                                        <span class="value" id="maxTemp">--</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="label">Rata-rata</span>
                                        <span class="value" id="avgTemp">--</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="temp-chart mt-4">
                            <canvas id="tempChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Water Level Modal -->
        <div class="modal fade" id="levelModal" tabindex="-1" aria-labelledby="levelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="levelModalLabel">Detail Level Air</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="current-level">
                                    <h3>Level Saat Ini</h3>
                                    <div class="level-gauge">
                                        <div class="gauge-value"><?php echo e($sensorData['level_air'] ?? '--'); ?>%</div>
                                        <div class="gauge-bar">
                                            <div class="gauge-fill" style="height: <?php echo e($sensorData['level_air'] ?? 0); ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="level-stats">
                                    <div class="stat-item">
                                        <span class="label">Min (24 jam)</span>
                                        <span class="value" id="minLevel">--</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="label">Max (24 jam)</span>
                                        <span class="value" id="maxLevel">--</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="label">Status</span>
                                        <span class="value text-success">Normal</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="level-chart mt-4">
                            <canvas id="levelChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Water Quality Modal -->
        <div class="modal fade" id="qualityModal" tabindex="-1" aria-labelledby="qualityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qualityModalLabel">Detail Kualitas Air</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="current-quality">
                                    <h3>Kualitas Saat Ini</h3>
                                    <div class="quality-status">
                                        <div class="status-value"><?php echo e($sensorData['kualitas_air'] ?? 'Baik'); ?></div>
                                        <div class="status-indicators">
                                            <div class="indicator">
                                                <span class="label">pH</span>
                                                <span class="value"><?php echo e($sensorData['ph'] ?? '--'); ?></span>
                                            </div>
                                            <div class="indicator">
                                                <span class="label">TDS</span>
                                                <span class="value"><?php echo e($sensorData['tds'] ?? '--'); ?> ppm</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="quality-stats">
                                    <div class="stat-item">
                                        <span class="label">Rentang pH</span>
                                        <span class="value">6.8 - 7.5</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="label">Rentang TDS</span>
                                        <span class="value">150 - 300 ppm</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="label">Pengecekan Terakhir</span>
                                        <span class="value"><?php echo e(now()->format('H:i:s')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="quality-chart mt-4">
                            <canvas id="qualityChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Add Firebase Scripts -->
        <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts with data from controller
            const sensorData = <?php echo json_encode($sensorData, 15, 512) ?>;
            const historyData = <?php echo json_encode($historyData, 15, 512) ?>;

            // Update initial values
            if (sensorData) {
                // Update temperature
                const tempValue = document.querySelector('.temp-value');
                if (tempValue) {
                    tempValue.textContent = `${sensorData.suhu_ds18b20?.toFixed(1) || '--'}°C`;
                }
                
                // Update water level
                const levelValue = document.querySelector('.gauge-value');
                const levelFill = document.querySelector('.gauge-fill');
                if (levelValue && levelFill) {
                    const level = sensorData.level_air || 0;
                    levelValue.textContent = `${level}%`;
                    levelFill.style.height = `${level}%`;
                }
                
                // Update water quality
                const qualityValue = document.querySelector('.status-value');
                if (qualityValue) {
                    qualityValue.textContent = sensorData.kualitas_air || 'Baik';
                }

                // Update pH and TDS
                const phValue = document.querySelector('.indicator:nth-child(1) .value');
                const tdsValue = document.querySelector('.indicator:nth-child(2) .value');
                if (phValue && sensorData.ph) {
                    phValue.textContent = sensorData.ph.toFixed(1);
                }
                if (tdsValue && sensorData.tds) {
                    tdsValue.textContent = `${sensorData.tds} ppm`;
                }
            }

            // Temperature Chart
            const tempCtx = document.getElementById('tempChart').getContext('2d');
            const tempChart = new Chart(tempCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Suhu Air (°C)',
                        data: [],
                        borderColor: '#0891b2',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(8, 145, 178, 0.1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 24,
                            max: 28
                        }
                    }
                }
            });

            // Water Level Chart
            const levelCtx = document.getElementById('levelChart').getContext('2d');
            const levelChart = new Chart(levelCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Level Air (%)',
                        data: [],
                        borderColor: '#0891b2',
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(8, 145, 178, 0.1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 80,
                            max: 90
                        }
                    }
                }
            });

            // Water Quality Chart
            const qualityCtx = document.getElementById('qualityChart').getContext('2d');
            const qualityChart = new Chart(qualityCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Level pH',
                        data: [],
                        borderColor: '#10b981',
                        tension: 0.4,
                        fill: false
                    }, {
                        label: 'TDS (ppm)',
                        data: [],
                        borderColor: '#0891b2',
                        tension: 0.4,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });

            // Update charts with historical data
            if (historyData) {
                const timestamps = Object.keys(historyData).sort();
                const tempData = timestamps.map(ts => historyData[ts].suhu_ds18b20 || 0);
                const levelData = timestamps.map(ts => historyData[ts].level_air || 0);
                const phData = timestamps.map(ts => historyData[ts].ph || 0);
                const tdsData = timestamps.map(ts => historyData[ts].tds || 0);

                // Update charts
                tempChart.data.labels = timestamps.map(ts => new Date(parseInt(ts)).toLocaleTimeString());
                tempChart.data.datasets[0].data = tempData;
                tempChart.update();

                levelChart.data.labels = timestamps.map(ts => new Date(parseInt(ts)).toLocaleTimeString());
                levelChart.data.datasets[0].data = levelData;
                levelChart.update();

                qualityChart.data.labels = timestamps.map(ts => new Date(parseInt(ts)).toLocaleTimeString());
                qualityChart.data.datasets[0].data = phData;
                qualityChart.data.datasets[1].data = tdsData;
                qualityChart.update();

                // Update statistics
                if (tempData.length > 0) {
                    const minTemp = Math.min(...tempData);
                    const maxTemp = Math.max(...tempData);
                    const avgTemp = tempData.reduce((a, b) => a + b, 0) / tempData.length;
                    
                    document.getElementById('minTemp').textContent = `${minTemp.toFixed(1)}°C`;
                    document.getElementById('maxTemp').textContent = `${maxTemp.toFixed(1)}°C`;
                    document.getElementById('avgTemp').textContent = `${avgTemp.toFixed(1)}°C`;
                }

                if (levelData.length > 0) {
                    const minLevel = Math.min(...levelData);
                    const maxLevel = Math.max(...levelData);
                    
                    document.getElementById('minLevel').textContent = `${minLevel}%`;
                    document.getElementById('maxLevel').textContent = `${maxLevel}%`;
                }
            }

            // Set up polling for real-time updates
            setInterval(() => {
                fetch('/api/sensor-data')
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            // Update temperature
                            const tempValue = document.querySelector('.temp-value');
                            if (tempValue) {
                                tempValue.textContent = `${data.suhu_ds18b20?.toFixed(1) || '--'}°C`;
                            }
                            
                            // Update water level
                            const levelValue = document.querySelector('.gauge-value');
                            const levelFill = document.querySelector('.gauge-fill');
                            if (levelValue && levelFill) {
                                const level = data.level_air || 0;
                                levelValue.textContent = `${level}%`;
                                levelFill.style.height = `${level}%`;
                            }
                            
                            // Update water quality
                            const qualityValue = document.querySelector('.status-value');
                            if (qualityValue) {
                                qualityValue.textContent = data.kualitas_air || 'Baik';
                            }

                            // Update pH and TDS
                            const phValue = document.querySelector('.indicator:nth-child(1) .value');
                            const tdsValue = document.querySelector('.indicator:nth-child(2) .value');
                            if (phValue && data.ph) {
                                phValue.textContent = data.ph.toFixed(1);
                            }
                            if (tdsValue && data.tds) {
                                tdsValue.textContent = `${data.tds} ppm`;
                            }

                            // Update last check time
                            const lastCheck = document.querySelector('.quality-stats .stat-item:last-child .value');
                            if (lastCheck) {
                                lastCheck.textContent = new Date().toLocaleTimeString();
                            }
                        }
                    })
                    .catch(error => console.error('Error fetching sensor data:', error));
            }, 5000); // Update every 5 seconds

            // Initialize Firebase
            const firebaseConfig = {
                apiKey: "AIzaSyC6zxY_ljbhoQEMbZYHuDRNZ2GGUbswQes",
                authDomain: "smart-aquarium-3720d.firebaseapp.com",
                databaseURL: "https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app",
                projectId: "smart-aquarium-3720d",
                storageBucket: "smart-aquarium-3720d.firebasestorage.app",
                messagingSenderId: "135942126154",
                appId: "1:135942126154:web:8e4a38acbf4b5acddfc4b3",
                measurementId: "G-0GWKLMJRSL"
                };

            // Initialize Firebase
            const app = firebase.initializeApp(firebaseConfig);
            const database = firebase.database();

            // Listen for sensor data changes
            database.ref('dashboard/sensor').on('value', (snapshot) => {
                const data = snapshot.val();
                if (data) {
                    // Update temperature
                    const suhuAir = document.getElementById('suhuAir');
                    if (suhuAir) {
                        suhuAir.textContent = data.suhu_ds18b20 ? data.suhu_ds18b20.toFixed(1) + '°C' : '--';
                        suhuAir.classList.add('updated');
                        setTimeout(() => suhuAir.classList.remove('updated'), 1000);
                    }

                    // Update water level
                    const levelAir = document.getElementById('levelAir');
                    if (levelAir) {
                        levelAir.textContent = data.level_air ? data.level_air.toFixed(1) + '%' : '--';
                        levelAir.classList.add('updated');
                        setTimeout(() => levelAir.classList.remove('updated'), 1000);
                    }

                    // Update humidity
                    const kelembaban = document.getElementById('kelembaban');
                    if (kelembaban) {
                        kelembaban.textContent = data.kelembapan ? data.kelembapan.toFixed(1) + '%' : '--';
                        kelembaban.classList.add('updated');
                        setTimeout(() => kelembaban.classList.remove('updated'), 1000);
                    }
                }
            });
        });
        </script>

        <style>
            :root {
                --primary: #0891b2;
                --secondary: #06b6d4;
                --success: #10b981;
                --danger: #ef4444;
                --warning: #f59e0b;
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

            .welcome-container {
                padding: 3rem 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                position: relative;
                z-index: 2;
            }

            .welcome-card {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 1.5rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
                overflow: hidden;
                backdrop-filter: blur(10px);
            }

            .welcome-header {
                background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
                padding: 3rem;
                color: white;
                position: relative;
                overflow: hidden;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .header-content h1 {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1rem;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            }

            .header-content p {
                font-size: 1.2rem;
                opacity: 0.9;
                margin: 0;
            }

            .header-image img {
                width: auto;
                max-width: 250px;
                height: auto;
                object-fit: contain;
                filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
            }


            .welcome-body {
                padding: 3rem;
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

            .stat-card.level {
                background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%);
            }

            .stat-card.quality {
                background: linear-gradient(135deg, #dcfce7 0%, #86efac 100%);
            }

            .stat-content {
                display: flex;
                align-items: center;
                width: 100%;
            }

            .stat-icon {
                font-size: 2rem;
                margin-right: 15px;
                color: rgba(0, 0, 0, 0.2);
            }

            .stat-info {
                flex: 1;
            }

            .stat-value {
                font-size: 1.5rem;
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 5px;
            }

            .stat-label {
                color: #64748b;
                font-size: 0.9rem;
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

            .water-level-indicator {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 4px;
                background: rgba(33, 150, 243, 0.1);
            }

            .water-level {
                height: 100%;
                background: #2196f3;
                transition: height 0.3s ease;
            }

            .features-section {
                margin-top: 3rem;
            }

            .feature-card {
                background: white;
                border-radius: 1rem;
                padding: 2rem;
                text-align: center;
                height: 100%;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease;
            }

            .feature-card:hover {
                transform: translateY(-5px);
            }

            .feature-card i {
                font-size: 2.5rem;
                color: var(--primary);
                margin-bottom: 1.5rem;
            }

            .feature-card h3 {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 1rem;
                color: #1e293b;
            }

            .feature-card p {
                color: #64748b;
                font-size: 0.9rem;
                margin-bottom: 0;
            }

            .btn-primary {
                background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
                border: none;
                padding: 1rem 2rem;
                font-weight: 500;
                border-radius: 0.75rem;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(26, 35, 126, 0.2);
            }

            @media (max-width: 768px) {
                .welcome-container {
                    padding: 1.5rem 0;
                }

                .welcome-header {
                    padding: 2rem;
                    flex-direction: column;
                    text-align: center;
                }

                .header-content h1 {
                    font-size: 2.5rem;
                }

                .header-image {
                    margin-top: 2rem;
                }

                .header-image img {
                    width: 120px;
                    height: 120px;
                }

                .welcome-body {
                    padding: 2rem;
                }

                .stat-card {
                    margin-bottom: 1rem;
                }

                .feature-card {
                    margin-bottom: 1rem;
                }
            }

            /* Modal Styles */
            .modal-content {
                border-radius: 1rem;
                border: none;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            }

            .modal-header {
                background: linear-gradient(135deg, var(--primary) 0%, #164e63 100%);
                color: white;
                border-radius: 1rem 1rem 0 0;
                padding: 1.5rem;
            }

            .modal-body {
                padding: 2rem;
            }

            .current-temp, .current-level, .current-quality {
                text-align: center;
                padding: 1.5rem;
                background: #f8fafc;
                border-radius: 1rem;
            }

            .temp-value {
                font-size: 3rem;
                font-weight: 700;
                color: var(--primary);
                margin: 1rem 0;
            }

            .temp-trend {
                font-size: 0.9rem;
                color: #64748b;
            }

            .temp-trend.up {
                color: #10b981;
            }

            .temp-trend.down {
                color: #ef4444;
            }

            .stat-item {
                display: flex;
                justify-content: space-between;
                padding: 1rem;
                background: #f8fafc;
                border-radius: 0.5rem;
                margin-bottom: 0.5rem;
            }

            .stat-item .label {
                color: #64748b;
            }

            .stat-item .value {
                font-weight: 600;
                color: #1e293b;
            }

            .level-gauge {
                position: relative;
                width: 150px;
                height: 150px;
                margin: 1rem auto;
            }

            .gauge-value {
                position: absolute;
            }
        </style>
    </body>
</html>
<?php /**PATH D:\Pemrograman Web\smart-aquarium\resources\views/welcome.blade.php ENDPATH**/ ?>