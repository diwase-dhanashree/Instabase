<div class="box box-primary">
    <div class="box-body">
        <p class="text-right">
            <a class="btn btn-primary" href="<?= admin_url('faqs/create') ?>">Add New</a>
        </p>
        
        <hr />

        <table id="faqs-table" class="table table-responsive">
            <thead>
                <tr>
                    <th width="5%" class="text-center">ID</th>
                    <th>Question</th>
                    <th>Status</th>
                    <th>Sort Order</th>
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
    $('#faqs-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": "<?= admin_url('faqs/datatable') ?>",
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