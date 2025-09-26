<?php
$categories = $this->Categories
    ->find()
    ->where('parent_id IS NULL OR parent_id = 0')
    ->where('deleted', 0)
    ->get()
    ->result_array();
?>
<aside class="main-sidebar" id="sidebar-wrapper">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">CATEGORIES</li>
            <?php foreach($categories as $c) { ?>
                <li><a href="<?= url('category/' . $c['id']) ?>"><i class="fa fa-angle-right"></i> <span><?= $c['name'] ?></span></a></li>
            <?php } ?>
            <li class="header">INFORMATION</li>
            <li><a href="<?= url('faqs') ?>"><i class="fa fa-angle-right"></i> <span>FAQs</span></a></li>
            <li><a href="<?= url('contact-us') ?>"><i class="fa fa-angle-right"></i> <span>Contact Us</span></a></li>
        </ul>
    </section>
</aside>