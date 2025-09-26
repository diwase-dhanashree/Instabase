<h4 class="text-center"><strong>Login</strong></h4>
<p class="login-box-msg">Enter your email to receive OTP</p>

<?= form_open() ?>
<div class="form-group has-feedback">
    <input type="email" name="email" class="form-control" placeholder="Email Address" required />
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>

<div class="row">
    <div class="col-xs-8"></div>
    <div class="col-xs-4">
        <button type="submit" name="signin" value="1" class="btn btn-primary btn-block btn-flat">Next</button>
    </div>
</div>
<?= form_close() ?>
<script>
    setCookie('popupCookie', '', 0.0000001);
</script>