<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('dashboard') }}" class="site_title"><i class="fa fa-wrench"></i> <span>{{ config('app.name') }}</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            {{-- <div class="profile_pic">
                <img src="../src/images/img.jpg" alt="..." class="img-circle profile_img">
            </div> --}}
            <div class="profile_info">
                <span>Welcome, <h2>{{ Auth::user()->full_name }}</h2></span>
            </div>
        </div>
        <!-- /menu profile quick info -->

        {{-- <br /> --}}

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                {{-- <h3>General</h3> --}}
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-home"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile') }}">
                            <i class="fa fa-user"></i> Profile
                        </a>
                    </li>
                    <li><a><i class="fa fa-users"></i> Customer<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('customers.index') }}">Customer List</a></li>
                            <li><a href="{{ route('customers.create') }}">Add Customer</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-briefcase"></i> Order<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('orders.index') }}">Order List</a></li>
                        </ul>
                    </li>
                    <!--
                    <li><a><i class="fa fa-cubes"></i> Inventory<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('inventories.index') }}">Inventory List</a></li>
                            {{-- <li><a href="">Add Brand</a></li>
                            <li><a href="model_add.php">Add Model</a></li> --}}
                            <li><a href="{{ route('inventories.create') }}">Add Inventory</a></li>
                        </ul>
                    </li>-->
                    <li><a><i class="fa fa-code-fork"></i> Branch<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('branches.index') }}">Branch List</a></li>
                            <li><a href="{{ route('branches.create') }}">Add Branch</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i> User<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('users.index') }}">User List</a></li>
                            <li><a href="{{ route('users.create') }}">Add User</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-tags"></i> Brand<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('brands.index') }}">Brand List</a></li>
                            <li><a href="{{ route('brands.create') }}">Add Brand</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-gift"></i> Product<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('products.index') }}">Product List</a></li>
                            <li><a href="{{ route('products.create') }}">Add Product</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                    </li>
                </ul> <!-- end .nav .side-menu -->
            </div> <!-- end div.menu_section -->

        </div>
        <!-- end #sidebar-menu -->

    </div> <!-- end .left_col .scroll-view -->
</div> <!-- end .left_col -->
