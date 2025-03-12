<?php
$fieldDef = $fields[$k];
$fieldVal = explode(',', $_SESSION['filter'][$k]);
?>
<input name="fv" type="hidden" value="<?= isset($_SESSION['filtertype'][$k]) ? $_SESSION['filtertype'][$k] : 6 ?>" />
<div class="row">
    <div class="col-1">&nbsp;</div>
    <div class="col-8 mb-2" id="<?= $k ?>Vals">
        <?php foreach ($fieldDef['selectFrom'] as $kk => $vv) { ?>
            <input type="checkbox" name="<?= $k ?>[]" id="<?= $k . $kk ?>" value="<?= $kk ?>" <?= in_array($kk, $fieldVal) ? ' checked' : '' ?>>
            <label for="<?= $k . $kk ?>"> <?= $vv ?></label><br>
        <?php } ?>
    </div>
    <div class="col-2">
        <button onclick="document.ff.fv.value=6;document.ff.submit()" class='btn btn-secondary col' type="button">
            <i class="fa fa-check <?= $tmpText ?>"></i>
        </button>
        <br>
        <br>

        <button onclick="document.ff.fv.value=5;document.ff.submit()" class='btn btn-danger col' type="button">
            <i class="fa fa-times <?= $tmpText ?>"></i>
        </button>
    </div>
</div>