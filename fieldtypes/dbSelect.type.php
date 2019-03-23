<?php
    if(!isset($fieldDef['defaultValue'])) $fieldDef['defaultValue']='';
    if(!isset($fieldDef['defaultResult'])) $fieldDef['defaultResult']='N/A';
    if(!isset($fieldDef['field'])) $fieldDef['field']='*';
            
    if($fieldValue==$fieldDef['defaultValue']) {
        echo $fieldDef['defaultResult'];
    } else { 
        $rr=db_select($fieldDef['field'], $fieldDef['table'], "$fieldDef[relatedField] = '$fieldValue'")[0];
        echo $rr[$fieldDef['field']];         
    }       
?>