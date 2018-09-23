<?=
    date(             
            (empty($fieldDef['format'])?'d.m.Y H:i':$fieldDef['format']),
            strtotime($fieldValue)
        );
?>