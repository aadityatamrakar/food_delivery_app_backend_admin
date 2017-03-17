<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">TromBoy Admin</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Dashboard <span class="sr-only">(current)</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Masters <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(route('city')); ?>">City & Area</a></li>
                        <li><a href="<?php echo e(route('restaurants')); ?>">Restaurants</a></li>
                        <li><a href="<?php echo e(route('customers')); ?>">Customers</a></li>
                        <li><a href="<?php echo e(route('coupon')); ?>">Coupons</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo e(route('orders')); ?>">Orders</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Outstanding</a></li>
                        <li><a href="#">All Orders</a></li>
                        <li><a href="#">Revenue</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Payments <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(route('payment.index')); ?>?requestedonly=1">Requested</a></li>
                        <li><a href="<?php echo e(route('payment.index')); ?>">Completed</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo e(route('customers')); ?>">Users</a></li>
                <li><a href="<?php echo e(route('wallet.index')); ?>">Wallet</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo e(route('logout')); ?>">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>