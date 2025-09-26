<div class="box box-primary">
    <div class="box-body">
        <?= form_open() ?>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="name" class="required">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= isset($row['name']) ? $row['name'] : "" ?>" required />
                </div>

                <div class="form-group col-sm-6">
                    <label for="parent_id">Parent Category</label>
                    <select id="parent_id" name="parent_id" class="form-control">
                        <option value=""></option>
                        <?php foreach ($categories as $cid => $cname) { ?>
                        <option value="<?= $cid ?>" <?= isset($row['parent_id']) && $row['parent_id'] == $cid ? 'selected' : '' ?>><?= $cname ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-sm-12">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button> 
                    <a href="<?= admin_url('productcategories') ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>
