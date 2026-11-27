<?php
if (!isset($fieldDef['defaultValue'])) $fieldDef['defaultValue'] = '';
if (!isset($fieldDef['defaultResult'])) $fieldDef['defaultResult'] = t('not_available');
if (!isset($fieldDef['field'])) $fieldDef['field'] = '*';

if ($fieldValue == $fieldDef['defaultValue']) {
    echo $fieldDef['defaultResult'];
} else {
    $rr = db_select($fieldDef['field'], $fieldDef['table'], "$fieldDef[relatedField] = '" . db_esc($fieldValue) . "'")[0];
    echo $rr[$fieldDef['field']];
}
