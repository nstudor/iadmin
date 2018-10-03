<?php
    $rr=db_select('*', $fieldDef['table'], isset($fieldDef['selectWhere'])?$fieldDef['selectWhere']:1);
?><select name="item[<?php echo $fieldId ?>]" class="form-control" id="ajaxitem">
    <option value="<?= $fieldDef['defaultValue'] ?>"><?= $fieldDef['defaultResult'] ?></option>
    <?php foreach($rr as $kk=>$vv) { ?>
    <option value="<?= $vv[$fieldDef['relatedField']] ?>"><?= $vv[$fieldDef['field']] ?></option>
<?php } ?>            
</select>
     