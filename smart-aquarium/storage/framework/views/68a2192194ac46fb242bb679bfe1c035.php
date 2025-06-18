<?php $__env->startPush('styles'); ?>
<style>
    :root {
        --primary: #0891b2;
        --secondary: #06b6d4;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --dark: #0f172a;
        --light: #f8fafc;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f9ff;
        color: #1e293b;
    }

    /* Sensor Cards */
    .stat-card {
        border-radius: 15px;
        position: relative;
        overflow: hidden;
        padding: 30px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 150px;
    }

    .stat-card.temp {
        background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%);
    }

    .stat-card.level {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    }

    .stat-card.quality {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-icon {
        position: absolute;
        right: -15px;
        bottom: -15px;
        font-size: 100px;
        opacity: 0.2;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 5px;
        line-height: 1;
    }

    .stat-label {
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.8;
    }

    /* Control Cards */
    .control-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .control-card:hover {
        transform: translateY(-5px);
    }

    .control-icon {
        width: 50px;
        height: 50px;
        background: #e3f2fd;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #2196F3;
    }

    .control-info {
        flex: 1;
    }

    .control-info h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .control-info p {
        margin: 0;
        font-size: 0.9rem;
        color: #64748b;
    }

    /* Alert styles */
    .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        min-width: 300px;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Button styles */
    .btn-primary {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        border: none;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(33, 150, 243, 0.4);
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    }

    .btn-primary:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Live Clock */
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
</style>
<?php $__env->stopPush(); ?> <?php /**PATH D:\Pemrograman Web\smart-aquarium\resources\views/dashboard/dashboard-styles.blade.php ENDPATH**/ ?>