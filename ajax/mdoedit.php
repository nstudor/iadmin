<?php
$k = $_POST['field'] ?? '';
if (!array_key_exists($k, $fields)) die(showMessage('Invalid field !', 'danger'));
$where = "$id='" . db_esc($_POST['id'] ?? '') . "'";
db_update([$k => $_POST['item'] ?? ''], $tabel, $where);
$r = db_select('*', $tabel, $where)[0] ?? [];
if (file_exists("../settings/$pag/{$k}_show.php")) include("../settings/$pag/{$k}_show.php");
else fieldFormat($k, $fields[$k], $r[$k] ?? '', '', '../');
