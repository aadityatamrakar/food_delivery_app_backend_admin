<?php $__env->startSection('style'); ?>
    <style>
        .myinput{
            width:100%;
            margin: 0;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(isset($restaurant)): ?>
         <h2>Orders | Restaurant: <?php echo e($restaurant->name); ?></h2>
    <?php elseif(isset($customer)): ?>
        <h2>Orders | Customer: <?php echo e($customer->name); ?></h2>
    <?php else: ?>
        <h2>Orders</h2>
    <?php endif; ?>
    <hr>
    <table class="table table-bordered" id="order_tbl">
        <thead>
        <tr>
            <th width="5%">#</th>
            <?php if(!isset($customer)): ?><th>User</th><?php endif; ?>
            <?php if(!isset($restaurant)): ?><th>Restaurant</th><?php endif; ?>
            <th width="5%">Info</th>
            <th width="5%">Amount</th>
            <th width="5%">Coupon</th>
            <th width="5%">Deliver</th>
            <th width="5%">Status</th>
            <th width="5%">Payment</th>
            <th width="5%">City</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($orders as $index=>$order): ?>
            <tr>
                <td><a href="<?php echo e(route('orders.view', ['id'=>$order->id])); ?>"><?php echo e($order->id); ?></a></td>
                <?php if(!isset($customer)): ?><td><a href="<?php echo e(route('customers.view', ["id"=>$order->user->id])); ?>" target="child"><?php echo e($order->user->name); ?></a></td><?php endif; ?>
                <?php if(!isset($restaurant)): ?><td><a href="<?php echo e(route('restaurants.view', ["id"=>$order->restaurant->id])); ?>" target="_blank"><?php echo e($order->restaurant->name); ?></a></td><?php endif; ?>
                <td><a href="<?php echo e(route('orders.view', ['id'=>$order->id])); ?>">view</a></td>
                <td><?php echo e($order->gtotal); ?></td>
                <td><?php echo e($order->coupon!=''?\App\Coupon::find($order->coupon)->code:''); ?></td>
                <td><?php echo e($order->deliver); ?></td>
                <td><?php echo e($order->status); ?></td>
                <td><?php echo e($order->payment_modes); ?></td>
                <td><?php echo e($order->city); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y h:i:s A')); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <?php if(!isset($customer)): ?><td></td><?php endif; ?>
            <?php if(!isset($restaurant)): ?><td></td><?php endif; ?>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>

    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cart Details</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th colspan="3">Cart</th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody id="cartBody"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function (){
            $('[data-toggle="popover"]').popover({
                container: 'body',
                placement: 'top',
                title: "User Details"
            });

            $('#order_tbl tfoot td').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="myinput" placeholder="Search '+title+'" />' );
            } );

            // DataTable
            var table = $('#order_tbl').DataTable({
                "aaSorting": [[0,'desc']],
            });

            // Apply the search
            table.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                                .search( this.value )
                                .draw();
                    }
                } );
            } );
        });

        $('#cartModal').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget);
            var cart = JSON.parse(decodeURIComponent(btn.data('cart')));
            var modal = $(this), quantity = 0;
            var html = '', gtotal = btn.data('gtotal'), df= btn.data('df'), pf = btn.data('pf');
            console.log(cart);

            $.each(cart, function (i, v){
                html += '<tr><td>'+v['title']+'</td><td>'+v['quantity']+'</td><td>'+parseFloat(v['quantity']*v['price'])+'</td></tr>';
                quantity += v['quantity'];
            });

            if(df > 0) html+= "<tr><td colspan='2'>Delivery Fee</td><td>"+df+"</td></tr>";
            if(pf > 0) html+= "<tr><td colspan='2'>Packing Fee</td><td>"+pf+"</td></tr>";

            html+= "<tr><td>Total</td><td>"+quantity+"</td><td>"+gtotal+"</td></tr>";
            $("#cartBody").html(html);
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>