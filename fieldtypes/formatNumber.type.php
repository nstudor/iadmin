<?=
    number_format(
            $fieldValue, 
            (empty($fieldDef['decimals'])?2:$fieldDef['decimals']), 
            (empty($fieldDef['decSep'])?NULL:$fieldDef['decSep']), 
            (empty($fieldDef['thoSep'])?NULL:$fieldDef['thoSep']));
?>