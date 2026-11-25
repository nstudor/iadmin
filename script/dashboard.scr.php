<?php
unset($_SESSION['filter']);
unset($_SESSION['filtertype']);
$uid = (int)($ruser['id'] ?? 0);
$panelRows = db_select('DISTINCT rand', 'login__dashboard', "id_user IN (0,$uid)", 'rand') ?? [];
$panelFiles = [];
foreach ($panelRows as $k => $v) {
    $panelRows[$k]['panels'] = db_select('*', 'login__dashboard', "id_user IN (0,$uid) AND `rand`=" . (int)$v['rand'], 'ordine') ?? [];
    $panelFiles = array_merge($panelFiles, array_column($panelRows[$k]['panels'], 'fisier'));
}
// each panel script runs once and fills the data of all its panels
foreach (array_unique($panelFiles) as $fisier) {
    if (db_is_ident($fisier) && file_exists("script/dashboard/$fisier.php")) {
        include "script/dashboard/$fisier.php";
    }
}
