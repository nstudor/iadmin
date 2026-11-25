<?=
($fieldValue === null || $fieldValue === '') ? '' :
number_format(
    (float)$fieldValue,
    (int)($fieldDef['decimals'] ?? 2),
    $fieldDef['decSep'] ?? '.',
    $fieldDef['thoSep'] ?? ','
) . ($fieldDef['suffix'] ?? '');
?>
