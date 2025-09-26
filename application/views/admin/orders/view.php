<section class="invoice" style="margin: 0;">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Order #<?= $order['id'] ?>
                <small class="pull-right">Date: <?= date('d/M/Y h:i a', strtotime($order['created_at'])) ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <p class="lead">Details:</p>
            <table class="table table-bordered">
                <tr>
                    <th>First Name</th>
                    <td><?= $order['first_name'] ?></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><?= $order['last_name'] ?></td>
                </tr>
                <tr>
                    <th>Employee Id</th>
                    <td><?= $order['emp_id'] ?></td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td><?= $order['email'] ?></td>
                </tr>
                <tr>
                    <th>Address Line 1</th>
                    <td><?= $order['address_1'] ?></td>
                </tr>
                <tr>
                    <th>Address Line 2</th>
                    <td><?= $order['address_2'] ?></td>
                </tr>
                <tr>
                    <th>City</th>
                    <td><?= $order['address_3'] ?></td>
                </tr>
                <tr>
                    <th>State</th>
                    <td><?= $order['address_4'] ?></td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td><?= $order['contact_number'] ?></td>
                </tr>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <p class="lead">Products:</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="10%">Image</th>
                        <th>Product</th>
                        <th width="10%">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p) { ?>
                    <tr>
                        <td><img src="<?= uploaded_url($p['image']) ?>" class="img-responsive" /></td>
                        <td><?= $p['name'] ?></td>
                        <td align="center"><?= $p['qty'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-xs-12 table-responsive">
            <p class="lead">Tracking Details:</p>
            <?php if(isset($tracking->tracking_data->shipment_track_activities)) { ?>
            <ul class="tracking-list">
                <?php foreach($tracking->tracking_data->shipment_track_activities as $a) { ?>
                <li>
                    <b><?= date('d-M-Y h:i a', strtotime($a->date)) ?></b>
                    <br />
                    <?= $a->activity ?>
                </li>
                <?php } ?>
            </ul>
            <?php } else { ?>
            <br />
            <p>Aahh! There is no activities found. Please have some patience it will be updated soon.</p>
            <?php } ?>
        </div>
    </div>
</section>

<div class="row" style="margin-top: 20px;">
    <div class="col-sm-6">
        <a href="<?= admin_url('orders') ?>" class="btn btn-default">Back To Orders</a>
    </div>
    <div class="col-sm-6 text-right"></div>
</div>