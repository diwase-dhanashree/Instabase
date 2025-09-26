<div class="box box-primary">
    <div class="box-body">
        <?= form_open() ?>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?= isset($row['email']) ? $row['email'] : "" ?>" readonly />
                </div>
             
                <div class="form-group col-sm-4">
                    <label for="points">Points</label>
                    <input type="text" id="points" name="points" class="form-control numberonly" value="<?= isset($row['points']) ? $row['points'] : "" ?>" required />
                </div>
                
                <div class="form-group col-sm-12">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button> 
                    <a href="<?= admin_url('customers') ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>