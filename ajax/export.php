<?php
$oper = $pp[1];
if (!isset($id)) $id = 'id';
?>
<form method="post" action="./script/export.php">
    <input type="hidden" name="oper" value="<?= $oper ?>">
    <label for="exportFields"><?= t('export_fields') ?></label>
    <select class="form-control" name="fields[]" id='exportFields' multiple>
        <?php foreach ($fields as $k => $v) { ?>
            <option selected value='<?= $k ?>'><?= is_array($v) ? $v['name'] : $v ?></option>
        <?php } ?>
    </select>
    <hr>
    <label for="exportType"><?= t('export_to') ?></label>
    <select class="form-select" id='exportType' name="type">
        <?php foreach (($exportTo ?? []) as $v) { ?>
            <option value='<?= $v ?>'><?= t("export_to_$v") ?></option>
        <?php } ?>
    </select>
    <button type="submit" class="btn btn-secondary float-right m-2"><?= t('export') ?></button>
</form>
<script>
    setTimeout(
        function() {
            $("#exportFields").bsMultiSelect();
        }, 0);
</script>