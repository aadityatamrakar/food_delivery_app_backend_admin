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
                        <li><a href="{{ route('city') }}">City & Area</a></li>
                        <li><a href="{{ route('restaurants') }}">Restaurants</a></li>
                        <li><a href="{{ route('customers') }}">Users</a></li>
                        <li><a href="{{ route('coupon') }}">Coupons</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('orders') }}">Orders</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Oustanding</a></li>
                        <li><a href="#">Orders Summarised</a></li>
                        <li><a href="#">User Detail</a></li>
                        <li><a href="#">User Wallet Summary</a></li>
                        <li><a href="#">Merchant Detail</a></li>
                        <li><a href="#">Detail</a></li>
                    </ul>
                </li>
                <li><a href="#">Payment</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>