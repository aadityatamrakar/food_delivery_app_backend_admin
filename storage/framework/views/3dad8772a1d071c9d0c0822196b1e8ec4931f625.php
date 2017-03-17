<?php $__env->startSection('content'); ?>
    <h1>Hello <?php echo e(Auth::user()->name); ?></h1>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('partials.app_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>