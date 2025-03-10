<select name="item[<?php echo $fieldId ?>]" class="form-control" id="ajaxitem">
    <?php if (empty($fieldDef['defaultValue'])) { ?>
        <option value="<?= $fieldDef['defaultValue'] ?>"><?= $fieldDef['defaultResult'] ?></option>
    <?php } ?>
    <?php foreach ($fieldDef['selectFrom'] as $kk => $vv) { ?>
        <option value="<?= $kk ?>" <?= $fieldValue == $kk ? ' selected' : '' ?>><?= $vv ?></option>
    <?php } ?>
</select>