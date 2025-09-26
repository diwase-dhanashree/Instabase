<div class="box box-solid">
    <div class="box-body">
        <h4>Please select category from left panel</h4>
    </div>
</div>
<?php if($this->vars['site']['dashboard_banner']) { ?>
<div class="text-center"><img src="<?= uploaded_url($this->vars['site']['dashboard_banner']) ?>" alt="Banner" style="width: 100%; height: auto; margin:0 auto"></div>
<?php } ?>