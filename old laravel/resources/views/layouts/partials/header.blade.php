    <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><i class="fa fa-paper-plane-o"></i></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b> fly orient </b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="images/avatar/avatar5.png" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{ \Illuminate\Support\Facades\Auth::user()->f_name }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="images/avatar/avatar5.png" class="img-circle" alt="User Image">

                    <p>
                      {{ \Illuminate\Support\Facades\Auth::user()->f_name }}
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="" class="btn btn-default btn-flat"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                          Sign out
                      </a>

                      <form id="logout-form" action="" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
    </header>