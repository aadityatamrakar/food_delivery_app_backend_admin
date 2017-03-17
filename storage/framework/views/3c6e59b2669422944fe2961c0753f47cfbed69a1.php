<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('partials.pagetitle', ["button_text"=>"Add", "button_link"=>route('coupon.add'), "page_title"=>"Coupons"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Percent</th>
            <th>Max Amount</th>
            <th>Min. Amount</th>
            <th>Return Type</th>
            <th>Valid From</th>
            <th>Valid Till</th>
            <th>Times</th>
            <th>New Only</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach(\App\Coupon::all() as $index=>$coupon): ?>
            <tr>
                <td><?php echo e($index+1); ?></td>
                <td><?php echo e($coupon->code); ?></td>
                <td><?php echo e($coupon->percent); ?></td>
                <td><?php echo e($coupon->max_amount); ?></td>
                <td><?php echo e($coupon->min_amt); ?></td>
                <td><?php echo e($coupon->return_type); ?></td>
                <td><?php echo e($coupon->valid_from); ?></td>
                <td><?php echo e($coupon->valid_till); ?></td>
                <td><?php echo e($coupon->times); ?></td>
                <td><?php echo e($coupon->new_only); ?></td>
                <td><a href="<?php echo e(route('coupon.edit', ['id'=>$coupon->id])); ?>" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</a> <a href="#" onclick="removeCoupon('<?php echo e($coupon->id); ?>}')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Del</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        function removeCoupon(id)
        {
            if(confirm("Are you sure ?"))
            {
                $.ajax({
                    url: "<?php echo e(route('coupon.remove')); ?>",
                    async: true,
                    type:"POST",
                    data: {"id":id, "_token": "<?php echo e(csrf_token()); ?>"}
                }).done(function (e){
                    if(e =='ok'){
                        window.location.reload();
                    }
                }).fail(function (m){
                    alert("Error: "+m.responseJSON['name'][0]);
                });
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>