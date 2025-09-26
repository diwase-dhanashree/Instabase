<div class="box-group" id="accordion">
    <?php foreach($faqs as $k => $v) { ?>
    <div class="panel box box-default">
        <div class="box-header with-border">
            <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $k ?>">
                    <?= $v['question'] ?>
                </a>
            </h4>
        </div>
        <div id="collapse<?= $k ?>" class="panel-collapse collapse <?= $k == 0 ? 'in' : '' ?>">
            <div class="box-body" style="font-size: 16px;">
                <?= $v['answer'] ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>