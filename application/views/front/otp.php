<h4 class="text-center"><strong>Verify OTP</strong></h4>
<p class="login-box-msg">Enter OTP code that you received on your email</p>

<?= form_open() ?>
    <div class="form-group has-feedback"> 
    	<input type="email" name="email" class="form-control" placeholder="Email Address" value="<?= $email ?>" readonly /> 
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
    	<input type="text" name="otp" class="form-control" placeholder="OTP Code" required /> 
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <a href="<?= url('/') ?>">Back</a>
        </div>
        <div class="col-xs-4">
        	<button type="submit" name="signin" value="1" class="btn btn-primary btn-block btn-flat">Submit</button> 
        </div>
    </div>
<?= form_close() ?>