<select name="item[<?php echo $fieldId ?>]" class="form-control" id="ajaxitem">
    <option value="<?= $fieldDef['defaultValue'] ?>"><?= $fieldDef['defaultResult'] ?></option>
<?php foreach($fieldDef['selectFrom'] as $kk=>$vv) { ?>
    <option value="<?= $kk ?>"><?= $vv ?></option>
<?php } ?>            
</select>
     