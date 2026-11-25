<?php
if (isset($fieldDef['defaultValue']) && $fieldValue == $fieldDef['defaultValue']) {
    echo $fieldDef['defaultResult'] ?? '';
} else {
    echo $fieldDef['selectFrom'][$fieldValue] ?? $fieldValue;
}
