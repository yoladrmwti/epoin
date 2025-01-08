

<?php $__env->startSection('content'); ?>
<h1>register</h1>
<a href="<?php echo e(route('login')); ?>">login</a>
    <br><br>
    <form action="<?php echo e(route('store')); ?>" method="POST">

    <?php echo csrf_field(); ?>
    <label>Nama Lengkap</label><br>
    <input type="text"id="name" name="name" value="<?php echo e(old('name')); ?>"><br>
    
    <?php if($errors->has('name')): ?>
    <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
    <?php endif; ?>

    <br>
    <label>Email Adress</label><br>
    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"><br>

    <?php if($errors->has('email')): ?>
<span class="text-denger"><?php echo e($errors->first('email')); ?></span>
<?php endif; ?>

<br>
<label>password</label><br>
<input type="password" id="password"name="password"><br>

<?php if($errors->has('password')): ?>
<span class="text-denger"><?php echo e($errors->first('password')); ?></span>
<?php endif; ?>

<br>
<label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">confirm password</label>
</div class="col-md-6">
<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
</div>
<input type="submit" value="Register">
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\yola_epoin\resources\views/auth/register.blade.php ENDPATH**/ ?>