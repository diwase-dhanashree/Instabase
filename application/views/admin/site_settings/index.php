<div class="box box-primary">
    <div class="box-body">
        <?= form_open(admin_url('sitesettings/store')) ?>
            <div class="row">
                <!-- Logo Field -->
                <div class="form-group col-sm-4">
                    <label>Logo:</label>
                    <div class="input-group">
                        <input type="text" id="logo" name="logo" value="<?= $settings ? $settings['logo'] : '' ?>" class="form-control" readonly />
                        <span class="input-group-btn">
                            <a href="<?= file_manager('logo') ?>" class="btn btn-primary upload-btn"><i class="fa fa-picture-o"></i> Choose</a>
                            <a href="javascript:void(0)" class="btn btn-danger remove-upload-btn"><i class="fa fa-times"></i></a>
                        </span>
                    </div>
                    <div style="background: #ccc; display: inline-block; padding: 10px; margin-top: 10px;">
                        <img class="img-responsive" id="logo-preview" style="max-height: 100px;" src="<?= $settings ? uploaded_url($settings['logo']) : '' ?>" />
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <label>Login Page Background:</label>
                    <div class="input-group">
                        <input type="text" id="login_bg" name="login_bg" value="<?= $settings ? $settings['login_bg'] : '' ?>" class="form-control" readonly />
                        <span class="input-group-btn">
                            <a href="<?= file_manager('login_bg') ?>" class="btn btn-primary upload-btn"><i class="fa fa-picture-o"></i> Choose</a>
                            <a href="javascript:void(0)" class="btn btn-danger remove-upload-btn"><i class="fa fa-times"></i></a>
                        </span>
                    </div>
                    <div style="background: #ccc; display: inline-block; padding: 10px; margin-top: 10px;">
                        <img class="img-responsive" id="login_bg-preview" style="max-height: 100px;" src="<?= $settings ? uploaded_url($settings['login_bg']) : '' ?>" />
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <label>Terms Background:</label>
                    <div class="input-group">
                        <input type="text" id="terms_bg" name="terms_bg" value="<?= $settings ? $settings['terms_bg'] : '' ?>" class="form-control" readonly />
                        <span class="input-group-btn">
                            <a href="<?= file_manager('terms_bg') ?>" class="btn btn-primary upload-btn"><i class="fa fa-picture-o"></i> Choose</a>
                            <a href="javascript:void(0)" class="btn btn-danger remove-upload-btn"><i class="fa fa-times"></i></a>
                        </span>
                    </div>
                    <div style="background: #ccc; display: inline-block; padding: 10px; margin-top: 10px;">
                        <img class="img-responsive" id="terms_bg-preview" style="max-height: 100px;" src="<?= $settings ? uploaded_url($settings['terms_bg']) : '' ?>" />
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <label>Login Banner:</label>
                    <div class="input-group">
                        <input type="text" id="login_banner" name="login_banner" value="<?= $settings ? $settings['login_banner'] : '' ?>" class="form-control" readonly />
                        <span class="input-group-btn">
                            <a href="<?= file_manager('login_banner') ?>" class="btn btn-primary upload-btn"><i class="fa fa-picture-o"></i> Choose</a>
                            <a href="javascript:void(0)" class="btn btn-danger remove-upload-btn"><i class="fa fa-times"></i></a>
                        </span>
                    </div>
                    <div style="background: #ccc; display: inline-block; padding: 10px; margin-top: 10px;">
                        <img class="img-responsive" id="login_banner-preview" style="max-height: 100px;" src="<?= $settings ? uploaded_url($settings['login_banner']) : '' ?>" />
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <label>Dashboard Banner:</label>
                    <div class="input-group">
                        <input type="text" id="dashboard_banner" name="dashboard_banner" value="<?= $settings ? $settings['dashboard_banner'] : '' ?>" class="form-control" readonly />
                        <span class="input-group-btn">
                            <a href="<?= file_manager('dashboard_banner') ?>" class="btn btn-primary upload-btn"><i class="fa fa-picture-o"></i> Choose</a>
                            <a href="javascript:void(0)" class="btn btn-danger remove-upload-btn"><i class="fa fa-times"></i></a>
                        </span>
                    </div>
                    <div style="background: #ccc; display: inline-block; padding: 10px; margin-top: 10px;">
                        <img class="img-responsive" id="dashboard_banner-preview" style="max-height: 100px;" src="<?= $settings ? uploaded_url($settings['dashboard_banner']) : '' ?>" />
                    </div>
                </div>

                <!-- Admin Email Field -->
                <div class="form-group col-sm-4 hidden">
                    <label>Admin Email:</label>
                    <input type="text" name="admin_email" value="<?= $settings ? $settings['admin_email'] : '' ?>" class="form-control" />
                </div>

                <div class="form-group col-sm-12">
                    <label>Terms & Conditions:</label>
                    <textarea id="terms_conditions" name="terms_conditions" class="form-control editor" required><?= $settings ? $settings['terms_conditions'] : '' ?></textarea>
                </div>

                <div class="form-group col-sm-12">
                    <label>Contact Us:</label>
                    <textarea id="contact_us" name="contact_us" class="form-control editor" required><?= $settings ? $settings['contact_us'] : '' ?></textarea>
                </div>

                <!-- Submit Field -->
                <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>