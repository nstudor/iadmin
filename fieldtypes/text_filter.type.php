<div class="row">
    <div class="col-1">&nbsp;</div>
    <div class="col-8 mb-2">
        <input name="<?php echo $k ?>" type="text" class="form-control" value="<?php echo $_SESSION['filter'][$k] ?>" placeholder="<?= t('filter') ?>" />
        <input name="fv" type="hidden" value="<?php echo $_SESSION['filtertype'][$k] ?>" />
    </div>
    <div class="col-2">
        <button onclick="document.ff.fv.value=5;document.ff.submit()" class='btn btn-danger col' type="button">
            <i class="fa fa-times"></i>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=1;document.ff.submit()"> <i class="fas fa-signature"></i> <?= t('filter_like') ?></button>
    </div>
    <div class="col-6">
        <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=2;document.ff.submit()"> <i class="fab fa-slack-hash"></i> <?= t('filter_not_like') ?></button>
    </div>
    <div class="col-6">
        <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=3;document.ff.submit()"> <i class="fas fa-equals"></i> <?= t('filter_equal') ?></button>
    </div>
    <div class="col-6">
        <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=4;document.ff.submit()"> <i class="fas fa-not-equal"></i> <?= t('filter_different') ?></button>
    </div>
</div>
<div class="row">
    <div class="col-xs-1 col-sm-4 col-md-4 col-lg-4">&nbsp;</div>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">

    </div>
</div>