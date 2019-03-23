<?php
foreach ($panelRows as $rk => $rv)
    foreach ($rv['panels'] as $k => $v)
        if ($v['fisier'] == 'infoboxes') {
            parse_str($v['setari'], $panelRows[$rk]['panels'][$k]['setari']);
            include($panelRows[$rk]['panels'][$k]['setari']['box'].'/infobox.php');
            $panelRows[$rk]['panels'][$k]['data'] = $boxData;
            $panelRows[$rk]['panels'][$k]['no_box'] = 1;
        }