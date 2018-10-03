<?php
    $rr=db_select('*', $fieldDef['table'], isset($fieldDef['selectWhere'])?$fieldDef['selectWhere']:1);
?><select name="item[<?php echo $fieldId ?>]" class="form-control" id="ajaxitem">
<?php if(empty($fieldDef['defaultValue'])) { ?>
    <option value="<?= $fieldDef['defaultValue'] ?>"><?= $fieldDef['defaultResult'] ?></option>
<?php } ?>            
    <?php foreach($rr as $kk=>$vv) { ?>
    <option value="<?= $vv[$fieldDef['relatedField']] ?>"<?= $fieldValue = $vv[$fieldDef['relatedField']]?' selected':'' ?>><?= $vv[$fieldDef['field']] ?></option>
<?php } ?>            
</select>
     