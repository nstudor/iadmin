<?php
if (isset($_SESSION['userid'])) {
    $ruser = db_select('*', 'login__users', 'id=' . (int)$_SESSION['userid'])[0] ?? [];
    // rights of the current module, always loaded from the DB (never cached in the session)
    $rcr = load_rights($param[0]);
    if (isset($_SESSION['menudata'])) {
        $menu = $_SESSION['menudata'];
    } else {
        $menu = [];
        $re = db_select('*', 'login__menu', 'id!=0', 'ordine');
        if ($re) {
            foreach ($re as $r) {
                $menu[$r['id']] = $r;
                $rd = db_select('*', 'login__rights', 'id_menu=' . $r['id'] . " AND id_role=" . (int)($ruser['role'] ?? 0))[0] ?? [];
                $ok = false;
                if ($r['right'] == 'Y') {
                    $ok = true;
                }
                if (($rd['view_right'] ?? '') == 'Y') {
                    $ok = true;
                }
                $menu[$r['id']]['ok'] = $ok;
            }
            foreach ($menu as $m) {
                if (isset($menu[$m['id_tata']]) && (!$menu[$m['id_tata']]['ok']) && ($m['ok']) && ($m['right'] != 'Y')) {
                    $menu[$m['id_tata']]['ok'] = true;
                }
            }
            foreach ($menu as $m) {
                if (isset($menu[$m['id_tata']]) && (!$menu[$m['id_tata']]['ok']) && ($m['ok']) && ($m['right'] != 'Y')) {
                    $menu[$m['id_tata']]['ok'] = true;
                }
            }
            foreach ($menu as $k => $m) {
                if (!$m['ok']) {
                    unset($menu[$k]);
                }
            }
            $_SESSION['menudata'] = $menu;
        } else {
            showMessage("Access denied: " . $MESSAGE, 'danger');
        }
    }
}
?>
