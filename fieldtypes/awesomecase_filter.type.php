<?php
    $fieldDef=$fields[$k];
    if(!empty($fieldDef['template'])) include('awesomecase/'.$fieldDef['template'].'.tpl.type.php');
    
    if(!is_array($fieldDef['values'])) $fieldDef['values'] = explode(',', $fieldDef['values']);
    if(!is_array($fieldDef['chars'])) $fieldDef['chars'] = explode(',', $fieldDef['chars']);
    if(!is_array($fieldDef['colors'])) $fieldDef['colors'] = explode(',', $fieldDef['colors']);
    if(!is_array($fieldDef['classes'])) $fieldDef['classes'] = explode(',', $fieldDef['classes']);
    if(!is_array($fieldDef['fatype'])) $fieldDef['fatype'] = explode(',', $fieldDef['fatype']);
        
    foreach($fieldDef['values'] as $kk=>$vv) {
        $fieldDef['t'][$vv]=$fieldDef['chars'][$kk];
        $fieldDef['c'][$vv]=$fieldDef['colors'][$kk];
        $fieldDef['s'][$vv]=$fieldDef['classes'][$kk];
        $fieldDef['f'][$vv]=$fieldDef['fatype'][$kk];
    }

    $fieldVal=$_SESSION['filter'][$k]
?>
<input name="fv" type="hidden" value="<?= isset($_SESSION['filtertype'][$k])?$_SESSION['filtertype'][$k]:6 ?>" />
<div class="row checksOver">
<div class="col-1">&nbsp;</div>
<div class="col-8 mb-2" id="<?= $k ?>Vals">
<?php foreach($fieldDef['t'] as $kk=>$vv) { ?>
<input name="<?= $k ?>[]" type="checkbox" id="<?= $k.$kk ?>" value="<?= $kk ?>"<?= in_array($kk, $fieldVal)?' checked':'' ?> />
<label for="<?= $k.$kk ?>">
    <i class="fa<?= $fieldDef['f'][$kk] ?> fa-<?= $fieldDef['t'][$kk].' '.$fieldDef['s'][$kk] ?>" <?=(empty($fieldDef['c'][$kk])?'':' style="color: '.$fieldDef['c'][$kk].'"')?>'></i>
</label>
<?php } ?>
</div>
<div class="col-2">
    <button onclick="document.ff.fv.value=6;document.ff.submit()" class='btn btn-secondary col' type="button">     
    <i class="fa fa-check text-white"></i>
    </button>
    <br>
    <br>
    
    <button onclick="document.ff.fv.value=5;document.ff.submit()" class='btn btn-danger col' type="button">     
    <i class="fa fa-times text-white"></i>
    </button>
</div>

</div>

