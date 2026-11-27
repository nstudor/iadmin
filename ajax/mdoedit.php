<?php
// inline save of one field (right-click editor, awesomecase toggle, dashboard open/closed)
// reached through ajax/modal.php: session, CSRF token and modify_right are already checked there
$k = $_POST['field'] ?? '';
if (!array_key_exists($k, $fields) || (is_array($fields[$k]) && !empty($fields[$k]['noEdit']))) {
    http_response_code(400);
    die(showMessage(t('invalid_field'), 'danger'));
}
$item = $_POST['item'] ?? '';
// awesomecase fields only accept one of their values
if (is_array($fields[$k]) && ($fields[$k]['type'] ?? '') == 'awesomecase'
    && !in_array((string)$item, array_map('strval', awesomecase_def($fields[$k])['values']), true)) {
    http_response_code(400);
    die(showMessage(t('invalid_value'), 'danger'));
}
$where = "$id='" . db_esc($_POST['id'] ?? '') . "'";
db_update([$k => $item], $tabel, $where);
$r = db_select('*', $tabel, $where)[0] ?? [];
if (file_exists("../settings/$pag/{$k}_show.php")) include("../settings/$pag/{$k}_show.php");
else fieldFormat($k, $fields[$k], $r[$k] ?? '', '', '../', $r[$id] ?? 0, $pag);
