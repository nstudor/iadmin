<div class="row mb-1">
<div class="col-8 mb-1">
<?php
    $fieldDef=$fields[$k];
    $rr=db_select('*', $fieldDef['table'], isset($fieldDef['selectWhere'])?$fieldDef['selectWhere']:1);
?><select name="<?php echo $k ?>" class="form-control">
<?php if(empty($fieldDef['defaultValue'])) { ?>
    <option value="<?= $fieldDef['defaultValue'] ?>"><?= $fieldDef['defaultResult'] ?></option>
<?php } ?>            
    <?php foreach($rr as $kk=>$vv) { ?>
    <option value="<?= $vv[$fieldDef['relatedField']] ?>"<?= $fieldValue == $vv[$fieldDef['relatedField']]?' selected':'' ?>><?= $vv[$fieldDef['field']] ?></option>
<?php } ?>            
</select>
         
    <input name="fv" type="hidden" value="3" />
</div>
<div class="col-2 mb-1">
    <button onclick="document.ff.fv.value=3;document.ff.submit()" class='btn btn-secondary col' type="button">     
    <i class="fa fa-check text-white"></i>
    </button>
</div>
<div class="col-2 mb-1">
    <button onclick="document.ff.fv.value=5;document.ff.submit()" class='btn btn-danger col' type="button">     
    <i class="fa fa-times text-white"></i>
    </button>
</div>
</div>