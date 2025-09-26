<style>
.tracking-list { padding: 10px 0 0 20px; }
.tracking-list li { padding-bottom: 12px; }
</style>
<div class="row">
    <div class="col-sm-6">
        <div class="box box-solid">
            <div class="box-body">
                <h4>Order Details:</h4>
                <table class="table">
                    <tr>
                        <th>First Name:</th>
                        <td><?= $order['first_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Last Name:</th>
                        <td><?= $order['last_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Employee Id:</th>
                        <td><?= $order['emp_id'] ?></td>
                    </tr>
                    <tr>
                        <th>Email Address:</th>
                        <td><?= $order['email'] ?></td>
                    </tr>
                    <tr>
                        <th>Address Line 1:</th>
                        <td><?= $order['address_1'] ?></td>
                    </tr>
                    <tr>
                        <th>Address Line 2:</th>
                        <td><?= $order['address_2'] ?></td>
                    </tr>
                    <tr>
                        <th>City:</th>
                        <td><?= $order['address_3'] ?></td>
                    </tr>
                    <tr>
                        <th>State:</th>
                        <td><?= $order['address_4'] ?></td>
                    </tr>
                    <tr>
                        <th>Pincode:</th>
                        <td><?= $order['pincode'] ?></td>
                    </tr>
                    <tr>
                        <th>Contact Number:</th>
                        <td><?= $order['contact_number'] ?></td>
                    </tr>
                    <tr>
                        <th>Products:</th>
                        <td>
                            <ul style="padding-left:15px">
                                <?php foreach($products as $p) { ?>
                                <li><?= $p['qty'] ?> x <?= $p['name'] ?></li>
                                <?php } ?>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-solid">
            <div class="box-body">
                <h4>Tracking Details:</h4>
                <?php if(isset($sr_res->tracking_data->shipment_track_activities)) { ?>
                <ul class="tracking-list">
                    <?php foreach($sr_res->tracking_data->shipment_track_activities as $a) { ?>
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
    </div>
</div>