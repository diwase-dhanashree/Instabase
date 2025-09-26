<div class="box box-primary">
    <div class="box-body">
        <p class="text-right">
            <a class="btn btn-primary" href="<?= admin_url('orders/export') ?>">Export</a>
        </p>
        
        <hr />

        <table id="orders-table" class="table table-responsive">
            <thead>
                <tr>
                    <th width="5%" class="text-center">ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Employee ID</th>
                    <th width="15%">Created At</th>
                    <th width="10%" class="text-right">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script type="application/javascript">
$(function () {
    $('#orders-table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        "ajax":{
            "url": "<?= admin_url('orders/datatable') ?>",
            "dataType": "json",
            "type": "POST",
        },
        columnDefs: [
            {targets: [0], className: "text-center"},
            {targets: -1, orderable: false, className: "text-right"}
        ]
    });
})
</script>