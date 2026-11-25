<?php
/**
 * Parameters (optional, when the field definition is an array)
 * modalEdit : true = click the value to edit it in a modal (list pages)
 * modalSize : size of that modal: sm, lg (default), xl
 */
if (is_array($fieldDef) && !empty($fieldDef['modalEdit']) && $uri != '') {
    $modalSize = preg_match('/^(sm|lg|xl)$/', (string)($fieldDef['modalSize'] ?? '')) ? $fieldDef['modalSize'] : 'lg';
    echo '<span role="button" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="goModal(\'edit-' . "$uri-$fieldId-$rowId" . '\', \'Edit\', \'' . $modalSize . '\')">'
        . ((string)$fieldValue === '' ? '<i class="fa fa-pen opacity-50"></i>' : $fieldValue) . '</span>';
} else {
    echo $fieldValue;
}
