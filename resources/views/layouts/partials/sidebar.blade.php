<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="images/avatar/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ \Illuminate\Support\Facades\Auth::user()->f_name }}</p>
                <i class="fa fa-circle text-success"></i> Online
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>
            <li class="{{ url()->current() ==url('/home') ? 'active' : '' }}">
                <a href="">
                    <i class="fa fa-connectdevelop "></i> <span>Home</span>
                </a>
            </li>

            <li class="treeview {{ url()->current() == route('admin.tickets') || url()->current() == route('admin.booked_tickets') || url()->current() == route('admin.bookings') ? 'menu-open active' : '' }}">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>Tickets</span>
                    <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ url()->current() == route('admin.tickets') ? 'active' : '' }}"><a
                                href="{{ route('admin.tickets') }}"><i class="fa fa-circle-o"></i> ticket List</a></li>
                    <li class="{{ url()->current() == route('admin.booked_tickets') ? 'active' : '' }}"><a
                                href="{{ route('admin.booked_tickets') }}"><i class="fa fa-circle-o"></i> booked ticket
                            List</a></li>
                    <li class="{{ url()->current() == route('admin.bookings') ? 'active' : '' }}"><a
                                href="{{ route('admin.bookings') }}"><i class="fa fa-circle-o"></i> bookings List</a>
                    </li>

                </ul>
            </li>

            <li class="treeview {{ url()->current() == route('admin.cip_tickets') || url()->current() == route('admin.cip_booked_tickets') || url()->current() == route('admin.cip_bookings') ? 'menu-open active' : '' }}">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>CIP Tickets</span>
                    <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ url()->current() == route('admin.cip_tickets') ? 'active' : '' }}"><a
                                href="{{ route('admin.cip_tickets') }}"><i class="fa fa-circle-o"></i> ticket List</a>
                    </li>
                    <li class="{{ url()->current() == route('admin.cip_booked_tickets') ? 'active' : '' }}"><a
                                href="{{ route('admin.cip_booked_tickets') }}"><i class="fa fa-circle-o"></i> booked
                            ticket
                            List</a></li>
                    <li class="{{ url()->current() == route('admin.cip_bookings') ? 'active' : '' }}"><a
                                href="{{ route('admin.cip_bookings') }}"><i class="fa fa-circle-o"></i> bookings
                            List</a>
                    </li>

                </ul>
            </li>

            <li class="treeview {{ url()->current() == route('admin.users')  ? 'menu-open active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ url()->current() == route('admin.users') ? 'active' : '' }}"><a
                                href="{{ route('admin.users') }}"><i class="fa fa-circle-o"></i> User List</a></li>
                    <li class="{{ url()->current() == url('/user/create') ? 'active' : '' }}"><a
                                href="{{ url('/user/create') }}"><i class="fa fa-circle-o"></i> Add User</a></li>
                </ul>
            </li>
            <li class="{{ url()->current() ==route('admin.agencies') ? 'active' : '' }}">
                <a href="{{ route('admin.agencies') }}">
                    <i class="fa fa-sliders"></i> <span>Agencies</span>
                </a>
            </li>

            <li class="{{ url()->current() ==route('admin.payments') ? 'active' : '' }}">
                <a href="{{ route('admin.payments') }}">
                    <i class="fa fa-sliders"></i> <span>payments</span>
                </a>
            </li>

            <li class="{{ url()->current() ==route('admin.pages') ? 'active' : '' }}">
                <a href="{{ route('admin.pages') }}">
                    <i class="fa fa-sliders"></i> <span>pages</span>
                </a>
            </li>


            <li class="{{ url()->current() ==route('admin.posts') ? 'active' : '' }}">
                <a href="{{ route('admin.posts') }}">
                    <i class="fa fa-sliders"></i> <span>posts</span>
                </a>
            </li>

            <li class="{{ url()->current() ==route('admin.faqs') ? 'active' : '' }}">
                <a href="{{ route('admin.faqs') }}">
                    <i class="fa fa-sliders"></i> <span>faqs</span>
                </a>
            </li>

            <li class="{{ url()->current() ==route('admin.upload') ? 'active' : '' }}">
                <a href="{{ route('admin.upload') }}">
                    <i class="fa fa-sliders"></i> <span>upload</span>
                </a>
            </li>
            <li class="{{ url()->current() ==route('admin.analyze') ? 'active' : '' }}">
                <a href="{{ route('admin.analyze') }}">
                    <i class="fa fa-sliders"></i> <span>Analyze</span>
                </a>
            </li>

            <li class="treeview {{ url()->current() == url('/invoice') || url()->current() == url('/invoice/create') ? 'menu-open active' : '' }}">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Invoice</span>
                    <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ url()->current() == url('/invoice') ? 'active' : '' }}"><a
                                href="{{ url('/invoice') }}"><i class="fa fa-circle-o"></i> Invoice List</a></li>
                    <li class="{{ url()->current() == url('/invoice/create') ? 'active' : '' }}"><a
                                href="{{ url('/invoice/create') }}"><i class="fa fa-circle-o"></i> Create Invoice</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ url()->current() == url('/customer') || url()->current() == url('/customer/create') ? 'menu-open active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Customers</span>
                    <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ url()->current() == url('/customer') ? 'active' : '' }}"><a
                                href="{{ url('/customer') }}"><i class="fa fa-circle-o"></i> Customer List</a></li>
                    <li class="{{ url()->current() == url('/customer/create') ? 'active' : '' }}"><a
                                href="{{ url('/customer/create') }}"><i class="fa fa-circle-o"></i> Add Customer</a>
                    </li>
                </ul>
            </li>
            <li class="header">Settings</li>
            <li class="{{ url()->current() ==route('admin.general_setting') ? 'active' : '' }}">
                <a href="{{ route('admin.general_setting') }}">
                    <i class="fa fa-sliders"></i> <span>General Setting</span>
                </a>
            </li>

            <li class="">
                <a href="{{ route('logout') }}"><i
                            class="fa fa-power-off"></i><span>Log out</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>