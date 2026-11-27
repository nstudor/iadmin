<?php
if ((isset($param[1])) && (!is_numeric($param[1]))) { // we have command
    $scriptPage = '404';
    $pag = $param[0];
    $id = 'id';
    $settingFile = "settings/$pag/config.php";
    if (!file_exists($settingFile)) $settingFile = "settings_default/$pag/config.php";

    // the command (add, edit, drop or a special) must be a plain name: it is used in include paths
    if (file_exists($settingFile) && db_is_ident($param[1])) {
        include($settingFile);
        $addfields = $fields;
        foreach ($addfields as $k => $v) if (is_array($v)) if ($v['noAdd'] ?? false) unset($addfields[$k]);
        $editfields = $fields;
        foreach ($editfields as $k => $v) if (is_array($v)) if ($v['noEdit'] ?? false) unset($editfields[$k]);
        $dropfields = $fields;
        foreach ($dropfields as $k => $v) if (is_array($v)) if ($v['noDel'] ?? false) unset($dropfields[$k]);
        $get = [];
        for ($i = 2; $i < count($param); $i += 2) $get[$param[$i]] = $param[$i + 1] ?? '';

        if (isset($get["id"]))
            $item = db_select('*', $tabel, "$id='" . db_esc($get['id']) . "'")[0] ?? [];

        if (file_exists("script/toper.$param[1].scr.php")) {
            include("script/toper.$param[1].scr.php");
            $scriptPage = "toper.$param[1]";
        } else {            
            if (file_exists(str_replace("config.php","$param[1].php",$settingFile))) {
                $scriptPage = str_replace("config.php","$param[1].php",$settingFile);                
            }
        }
    } else {
        $scriptPage = '404';
    }
} else {


    $items_per_page = 25;
    if ($dontshowpages ?? false) {
        $st = 0;
        $items_per_page = 1000000000;
    }

    if (!isset($id)) $id = 'id';

    if (isset($_POST['order']) && db_is_ident($_POST['order'])) {
        unset($_SESSION['order'][$_POST['order']]);
        if (in_array($_POST['ordertype'] ?? '', ['up', 'dn'], true)) $_SESSION['order'][$_POST['order']] = $_POST['ordertype'];
    }
    if (isset($param[1])) $st = (int)$param[1];
    else $st = ($_SESSION['st'] ?? 0) * 1;

    $pag = $param[0];

    if (file_exists($settingFile)) {
        foreach ($fields as $k => $v) if (is_array($v)) if ($v['noShow'] ?? false) unset($fields[$k]);
        if ($pag != ($_SESSION['page'] ?? '')) {
            unset($_SESSION['filter']);
            unset($_SESSION['defaults']);
            unset($_SESSION['order']);
            $_SESSION['page'] = $pag;
            $st = 0;
        }

        if ((($_POST['multi'] ?? '') == 'yes') && (count($_POST['d'] ?? []) > 0)) {
            foreach ($_POST as $k => $v) if (substr($k, 0, 4) == 'oper') $oper = substr($k, 5);
            $d = implode(",", $_POST['d']); ?>
            <script type="text/javascript">
                window.onload = function() {
                    Shadowbox.open({
                        content: 'modal.php?p=<?php echo $param[0] . '-' . $param[1] ?>-multi<?php echo $oper ?>&id=<?php echo $d ?>',
                        player: "iframe",
                        title: "Multi-Actiune",
                        height: <?php echo (isset($operheight[$oper]) ? $operheight[$oper] : 150) ?>,
                        width: <?php echo (isset($operwidth[$oper]) ? $operwidth[$oper] : 450) ?>
                    });
                }
            </script>
<?php }
        $_SESSION['st'] = $st;
        if (count($_SESSION['order'] ?? []) != 0) {
            $order = '';
            foreach ($_SESSION['order'] as $k => $v)
                if (db_is_ident($k) && in_array($v, ['up', 'dn'], true))
                    $order = "`$k` " . ($v == 'up' ? 'ASC' : 'DESC') . ", $order";
            $order = "$order $id";
        }
        if (isset($defaultOrder)) $order = $defaultOrder;
        $flt = "1";
        if (isset($param[2]))
            if (($param[3] ?? '') == 'filtru' && db_is_ident($param[4] ?? null))
                $flt = "`$param[4]`='" . db_esc($param[5] ?? '') . "'";

        if (isset($_POST['fld']) && db_is_ident($_POST['fld']))
            if (($_POST['fv'] ?? 0) != 5) {
                $_SESSION['filter'][$_POST['fld']] = $_POST[$_POST['fld']] ?? '';
                $_SESSION['filtertype'][$_POST['fld']] = $_POST['fv'];
            } else unset($_SESSION['filter'][$_POST['fld']], $_SESSION['filtertype'][$_POST['fld']]);
        if (($_POST['fv'] ?? 0) == 999) unset($_SESSION['filter'], $_SESSION['filtertype']); // clear all filters
        if (is_array($_SESSION['filter'] ?? null))
            foreach ($_SESSION['filter'] as $k => $raw) {
                if (!db_is_ident($k)) continue;
                $v = is_array($raw) ? array_map('db_esc', $raw) : db_esc($raw);
                switch ($_SESSION['filtertype'][$k] ?? 0) {
                    case 1:
                        $flt .= " AND `$k` LIKE '%$v%'";
                        break;
                    case 2:
                        $flt .= " AND `$k` NOT LIKE '%$v%'";
                        break;
                    case 3:
                        $flt .= " AND `$k`='$v'";
                        break;
                    case 4:
                        $flt .= " AND `$k`!='$v'";
                        break;
                    case 6:
                        $flt .= " AND `$k` IN ('" . implode("','", (array)$v) . "')";
                        break;
                    case 8:
                        $fa = array_map('db_esc', explode("~", (string)$raw, 2)) + ['', ''];
                        $flt .= " AND `$k`>='$fa[0]' AND `$k`<='$fa[1]'";
                        break;
                    case 9:
                        $flt .= " AND `$k` LIKE '$v'";
                        break;
                    case 11:
                        $flt .= " AND `$k`>'$v'";
                        break;
                    case 12:
                        $flt .= " AND `$k`<'$v'";
                        break;
                    case 13:
                        $flt .= " AND `$k`>='$v'";
                        break;
                    case 14:
                        $flt .= " AND `$k`<='$v'";
                        break;
                }
            }
        $filtersExists = 0;
        foreach ($fields as $k => $v) if (isset($_SESSION['filter'][$k])) $filtersExists++;
        $rn = db_select('count(*) nr', $tabel, $flt)[0];
        $np = ($rn == 0 ? 0 : floor(($rn['nr'] - 1) / $items_per_page));
        if ($st > $np) $st = $np;
        if ($st < 0) $st = 0;
        //        echo $flt;

        $rows = db_select('*', $tabel, $flt, $order ?? NULL, ($st * $items_per_page) . ', ' . $items_per_page);
        if ((count($rows ?? []) == 0) && empty($MESSAGE)) $MESSAGE = t('no_records');
        $nr = 0;
    } else {
        $MESSAGE = t('config_file_missing');
    }
}
