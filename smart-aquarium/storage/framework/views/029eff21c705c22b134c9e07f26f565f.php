<?php $__env->startSection('content'); ?>
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

<div class="login-container">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white text-center py-4">
            <h3 class="mb-0">Smart Aquarium</h3>
            <p class="mb-0">Login ke Akun Anda</p>
        </div>
        <div class="card-body p-4">
            <?php if(session('status')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Login as</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="loginType" id="loginUser" value="user" checked>
                        <label class="form-check-label" for="loginUser">User</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="loginType" id="loginAdmin" value="admin">
                        <label class="form-check-label" for="loginAdmin">Admin</label>
                    </div>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('login')); ?>" id="userLoginForm">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="remember">
                        Ingat Saya
                    </label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg" id="loginButton">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </div>
            </form>

            <form id="adminLoginForm" style="display:none;">
                <div class="mb-3">
                    <label for="adminEmail" class="form-label">Email</label>
                    <input id="adminEmail" type="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="adminPassword" class="form-label">Password</label>
                    <input id="adminPassword" type="password" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary btn-lg" id="firebaseLoginButton">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login as Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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

const loginUserRadio = document.getElementById('loginUser');
const loginAdminRadio = document.getElementById('loginAdmin');
const userLoginForm = document.getElementById('userLoginForm');
const adminLoginForm = document.getElementById('adminLoginForm');
const loginButton = document.getElementById('loginButton');
const firebaseLoginButton = document.getElementById('firebaseLoginButton');

function toggleLoginForms() {
    if (loginUserRadio.checked) {
        userLoginForm.style.display = 'block';
        adminLoginForm.style.display = 'none';
    } else {
        userLoginForm.style.display = 'none';
        adminLoginForm.style.display = 'block';
    }
}

loginUserRadio.addEventListener('change', toggleLoginForms);
loginAdminRadio.addEventListener('change', toggleLoginForms);

toggleLoginForms();

firebaseLoginButton.addEventListener('click', function() {
    const email = document.getElementById('adminEmail').value;
    const password = document.getElementById('adminPassword').value;

    auth.signInWithEmailAndPassword(email, password)
        .then((userCredential) => {
            return userCredential.user.getIdToken();
        })
        .then((idToken) => {
            fetch('<?php echo e(route("firebase.login")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ firebase_token: idToken })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'ok') {
                    window.location.href = '/dashboard';
                } else {
                    showNotif('danger', 'Firebase login failed: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                showNotif('danger', 'Firebase login error: ' + error.message);
            });
        })
        .catch((error) => {
            showNotif('danger', 'Login error: ' + error.message);
        });
});

function showNotif(type, message) {
    const notif = document.createElement('div');
    notif.className = `alert alert-${type} alert-dismissible fade show`;
    notif.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.querySelector('.card-body').insertBefore(notif, document.querySelector('form'));
    setTimeout(() => notif.remove(), 5000);
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\IPB\Semester 4\WEB\project v3\smart-aquarium\resources\views/auth/login.blade.php ENDPATH**/ ?>