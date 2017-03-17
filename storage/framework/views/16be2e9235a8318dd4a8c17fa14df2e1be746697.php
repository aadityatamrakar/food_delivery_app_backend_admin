<?php $__env->startSection('content'); ?>
    <h2>Customers</h2>
    <hr>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>City</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach(\App\Customer::orderBy('created_at', 'desc')->get() as $index=>$customer): ?>
                <tr>
                    <td><?php echo e($index+1); ?></td>
                    <td><?php echo e($customer->name); ?></td>
                    <td><?php echo e($customer->mobile); ?></td>
                    <td><?php echo e(\App\City::find($customer->city)->name); ?></td>
                    <td><a href="<?php echo e(route('customers.wallet', ['id'=>$customer->id])); ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-bitcoin"></i> Wallet</a> <a href="<?php echo e(route('customers.orders', ['id'=>$customer->id])); ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> Orders</a> <a href="<?php echo e(route('customers.view', ['id'=>$customer->id])); ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-user"></i> View</a> <a href="#" onclick="removeCustomer('<?php echo e($customer->id); ?>', this)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-user"></i> Del</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        function removeCustomer(id, t)
        {
            if(confirm("Are you sure ?"))
            {
                $.ajax({
                    url: "<?php echo e(route('removeCustomer')); ?>",
                    async: true,
                    type:"POST",
                    data: {"id":id, "_token": "<?php echo e(csrf_token()); ?>"}
                }).done(function (e){
                    if(e =='ok'){
                        $.notify("Customer Deleted.", "success");
                        $(t).parent().parent().remove();
                    }
                }).fail(function (m){
                    alert("Error: "+m.responseJSON['name'][0]);
                });
            }
        }
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('partials.app_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>