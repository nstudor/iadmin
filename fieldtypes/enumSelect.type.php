<?php
if ($fieldValue == $fieldDef['defaultValue']) {
    echo $fieldDef['defaultResult'];
} else {
    echo $fieldDef['selectFrom'][$fieldValue];
}
