<?php
$cart = $this->Cart
    ->find()
    ->where('customer_id', $this->user['id'])
    ->get()
    ->result_array();

$order = $this->Orders
    ->find()
    ->where('customer_id', $this->user['id'])
    ->get()
    ->row_array();
?>
<header class="main-header">
    <a href="<?= url('home') ?>" class="logo">
        <img src="<?= uploaded_url($this->vars['site']['logo']) ?>" style="max-height: 48px; display:none;" />
    </a>
    <nav class="navbar navbar-static-top">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><a href="#" style="cursor:default;">Points Available: <b><?= $this->user['points'] ?></b></a></li>
                <?php if ($order) { ?>
                    <li><a href="<?= url('/cart/track_order') ?>" title="Track Order"><i class="fa fa-truck" style="font-size:18px"></i></a></li>
                <?php } ?>
                <li>
                    <a href="<?= url('/cart') ?>">
                        <i class="fa fa-shopping-cart" style="font-size:18px"></i>
                        <span id="cart-count" class="label label-default" style="<?= $cart ? '' : 'display:none' ?>"><?= count($cart) ?></span>
                    </a>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= assets('images/avatar.png') ?>" class="user-image" alt="" />
                        <span class="hidden-xs"><?= $this->user['email'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="<?= url('logout') ?>" class="btn btn-danger btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>