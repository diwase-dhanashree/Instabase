<style>
.login-box { width: 100%; max-width: 800px; margin: 2% auto }
.login-toc { max-height: 400px; overflow: auto; }
.login-box-body { background-image: url(<?= uploaded_url($this->vars['site']['terms_bg']) ?>); background-size: cover; padding-top: 85px; background-repeat: no-repeat; }
</style>
<div class="login-toc">
    <?= isset($this->vars['site']['terms_conditions']) ? $this->vars['site']['terms_conditions'] : '' ?>
</div>

<hr />

<?= form_open() ?>
    <div class="row">
        <div class="col-xs-12 text-center">
        	<button type="submit" name="signin" value="1" class="btn btn-primary btn-flat">I Agree</button> 
            <a class="btn btn-default btn-flat" href="<?= url('/?disagree=1') ?>" style="margin-left:20px">I Disagree</a>
        </div>
    </div>
<?= form_close() ?>