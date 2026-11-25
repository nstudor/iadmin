<?php

/**
 * Parameters
 * mesaureUnit : The unit of measurement Ex: 'b' will show 123.45b,
 * unitSize : The size of the multiplier Ex: 1024 is for bytes, so 4096 will show 4K
 * maxDepth : 0-normal, 1 until K, 2 until M, 3 until G, 4 until T
 * prefix : Text before result
 * suffix : Text after result
 * modalEdit : true = click the value to edit it in a modal
 * modalSize : size of that modal: sm, lg (default), xl
 */
$modalSize = preg_match('/^(sm|lg|xl)$/', (string)($fieldDef['modalSize'] ?? '')) ? $fieldDef['modalSize'] : 'lg';
$mtxt1 = '<i role="button" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="goModal(\'edit-' . "$uri-$fieldId-$rowId" . '\', \'Edit\', \'' . $modalSize . '\')">';
$mtxt2 = '</i>';
$bytesLength = strlen((string)$fieldValue);
$unitSize = (empty($fieldDef['unitSize']) ? 1000 : $fieldDef['unitSize']);
$unitDefault = (empty($fieldDef['mesaureUnit']) ? '' : $fieldDef['mesaureUnit']);
$unitName = $unitDefault;
$maxDepth = (int)($fieldDef['maxDepth'] ?? 0);
$prefix = $fieldDef['prefix'] ?? '';
$suffix = $fieldDef['suffix'] ?? '';

foreach (['K', 'M', 'G', 'T'] as $level => $unit) {
    if (($maxDepth > $level) && ($bytesLength > $unitSize * 2)) {
        $bytesLength = round($bytesLength / $unitSize, 2);
        $unitName = $unit . $unitDefault;
    }
}
if (!empty($fieldDef['modalEdit'])) {
    $prefix = $mtxt1 . $prefix;
    $suffix = $suffix . $mtxt2;
}
echo $prefix . $bytesLength . $unitName . $suffix;
