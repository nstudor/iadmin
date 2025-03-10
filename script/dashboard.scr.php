<?php
unset($_SESSION['filter']);
unset($_SESSION['filtertype']);
$panelRows = db_select('DISTINCT rand', 'login_dashboard', 'id_user IN (0,' . $ruser['id'] . ')', 'rand');
$panelFiles = [];
foreach ($panelRows as $k => $v) {
    $panelRows[$k]['panels'] = db_select('*', 'login_dashboard', 'id_user IN (0,' . $ruser['id'] . ') AND `rand`=' . $v['rand'], 'ordine');
    $panelFiles = array_merge($panelFiles, array_column($panelRows[$k]['panels'], 'fisier'));
}
foreach ($panelFiles as $fisier) {
    include "script/dashboard/$fisier.php";
};
?>