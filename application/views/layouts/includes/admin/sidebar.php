<aside class="main-sidebar" id="sidebar-wrapper">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= assets('images/avatar.png') ?>" class="img-circle" alt="" />
            </div>
            <div class="pull-left info">
                <p><?= $this->user['first_name'] . ' ' . $this->user['last_name'] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?= is_request('dashboard') ? 'active' : '' ?>">
                <a href="<?= admin_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="<?= is_request('productcategories') ? 'active' : '' ?>">
                <a href="<?= admin_url('productcategories') ?>"><i class="fa fa-list"></i> <span>Categories</span></a>
            </li>
            <li class="<?= is_request('products') ? 'active' : '' ?>">
                <a href="<?= admin_url('products') ?>"><i class="fa fa-th"></i> <span>Products</span></a>
            </li>
            <li class="<?= is_request('orders') ? 'active' : '' ?>">
                <a href="<?= admin_url('orders') ?>"><i class="fa fa-shopping-cart"></i> <span>Orders</span></a>
            </li>
            <li class="<?= is_request('customers') ? 'active' : '' ?>">
                <a href="<?= admin_url('customers') ?>"><i class="fa fa-users"></i> <span>Customers</span></a>
            </li>
            <li class="<?= is_request('faqs') ? 'active' : '' ?>">
                <a href="<?= admin_url('faqs') ?>"><i class="fa fa-info"></i> <span>FAQs</span></a>
            </li>
            <li class="<?= is_request('sitesettings') ? 'active' : '' ?>">
                <a href="<?= admin_url('sitesettings') ?>"><i class="fa fa-cogs"></i> <span>Settings</span></a>
            </li>
            <li><a href="<?= admin_url('logout') ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
    </section>
</aside>