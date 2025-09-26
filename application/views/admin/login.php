<h4 class="text-center"><strong>Login</strong></h4>
<p>&nbsp;</p>
<p class="login-box-msg">Sign in to start your session</p>

<?= form_open() ?>
    <div class="form-group has-feedback"> 
    	<input type="email" name="email" class="form-control" placeholder="Email Address" required /> 
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
    	<input type="password" name="password" class="form-control" placeholder="Password" required /> 
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4">
        	<button type="submit" name="signin" value="1" class="btn btn-primary btn-block btn-flat">Sign In</button> 
        </div>
    </div>
<?= form_close() ?>