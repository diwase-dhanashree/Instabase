<header class="main-header">
    <a href="<?= admin_url('dashboard') ?>" class="logo">
        <span class="logo-mini"><b>A</b> P</span>
        <span class="logo-lg"><b>Admin</b> Panel</span>
    </a>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><a href="<?= url('/') ?>" target="_blank"><i class="fa fa-desktop"></i></a></li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= assets('images/avatar.png') ?>" class="user-image" alt="" />
                        <span class="hidden-xs"><?= $this->user['first_name'] . ' ' . $this->user['last_name'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="<?= admin_url('profile') ?>" class="btn btn-primary btn-flat">Edit Profile</a>
                                &nbsp;
                                <a href="<?= admin_url('logout') ?>" class="btn btn-danger btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>