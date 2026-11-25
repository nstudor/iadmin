<?php
    if(!empty($fieldDef['displayLocale'])) {
        setlocale(LC_ALL, $fieldDef['displayLocale']);
    }
    $fieldValue = (string)($fieldValue ?? '');
    $format = $fieldDef['format'] ?? '';
    echo ($fieldValue === '' || $fieldValue[0] == '0') ? (empty($fieldDef['nodate']) ? 'N/A' : $fieldDef['nodate']) :
        (strpos($format, '%') === false ?
            date((empty($format) ? 'd.m.Y H:i' : $format), strtotime($fieldValue)) :
            format_strftime($format, strtotime($fieldValue))
        );
?>
