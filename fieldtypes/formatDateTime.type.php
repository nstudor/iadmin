<?php
    if(!empty($fieldDef['displayLocale'])) {
        setlocale(LC_ALL, $fieldDef['displayLocale']);
    }
    echo $fieldValue[0]=='0'?(empty($fieldDef['nodate'])?'N/A':$fieldDef['nodate']):
    (strpos($fieldDef['format'],'%')===false?
    date(             
            (empty($fieldDef['format'])?'d.m.Y H:i':$fieldDef['format']),
            strtotime($fieldValue)
        ):
        strftime(
            $fieldDef['format'],
            strtotime($fieldValue)
        )
    );
?>