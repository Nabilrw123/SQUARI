

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h1>Users</h1>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary mb-3">Add New User</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($user->name); ?></td>
                <td><?php echo e($user->email); ?></td>
                <td><?php echo e(ucfirst($user->role)); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4">No users found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php echo e($users->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\IPB\Semester 4\WEB\project v3\smart-aquarium\resources\views/admin/users/index.blade.php ENDPATH**/ ?>