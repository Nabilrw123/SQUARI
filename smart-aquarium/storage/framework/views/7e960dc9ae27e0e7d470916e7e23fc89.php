

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h1>Edit User</h1>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.users.update', $user)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="user" <?php echo e(old('role', $user->role) == 'user' ? 'selected' : ''); ?>>User</option>
                <option value="admin" <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (leave blank to keep current)</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Pemrograman Web\smart-aquarium\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>