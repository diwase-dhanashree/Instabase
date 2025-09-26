<div class="box box-primary">
    <div class="box-body">
        <?= form_open() ?>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="first_name" class="required">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="<?= $user['first_name'] ?>" required />
                </div>

                <div class="form-group col-sm-6">
                    <label for="last_name" >Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" value="<?= $user['last_name'] ?>"  />
                </div>

                <div class="form-group col-sm-6">
                    <label for="email" class="required">Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?= $user['email'] ?>" required />
                </div>

                <div class="col-sm-12">
                    <hr />

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="password">New Password</label>
                            <input type="password" id="password" name="password" class="form-control" />
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="repassword">Confirm Password</label>
                            <input type="password" id="repassword" name="repassword" class="form-control" />
                        </div>
                    </div>
                </div>
               
                <div class="form-group col-sm-12">
                    <button type="submit" name="submit" class="btn btn-primary">Update</button> 
                    <a href="<?= admin_url('dashboard') ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>