<div class="box box-primary">
    <div class="box-body">
        <div class="text-right">
            <a href="<?= admin_url('customers/export?ordered=1') ?>" class="btn btn-primary">Export Ordered</a>
            &nbsp;&nbsp;&nbsp;
            <a href="<?= admin_url('customers/export?ordered=0') ?>" class="btn btn-primary">Export Not Ordered</a>
        </div>
        <br />
        <table id="customers-table" class="table table-responsive">
            <thead>
                <tr>
                    <th width="5%" class="text-center">ID</th>
                    <th>Email</th>
                    <th width="10%">Points</th>
                    <th width="15%">Order Placed</th>
                    <th width="10%" class="text-right">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script type="application/javascript">
$(function () {
    $('#customers-table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "ajax":{
            "url": "<?= admin_url('customers/datatable') ?>",
            "dataType": "json",
            "type": "POST",
        },
        columnDefs: [
            {targets: [0, 2], className: "text-center"},
            {targets: -1, orderable: false, className: "text-right"}
        ]
    });
})
</script>