<?=
number_format(
    $fieldValue,
    (!isset($fieldDef['decimals']) ? 2 : $fieldDef['decimals']),
    (!isset($fieldDef['decSep']) ? NULL : $fieldDef['decSep']),
    (!isset($fieldDef['thoSep']) ? NULL : $fieldDef['thoSep'])
) . $fieldDef['suffix'];
?>