<?php
foreach ($panelRows as $rk => $rv)
    foreach ($rv['panels'] as $k => $v)
        if ($v['fisier'] == 'shortcuts') {
            $panelRows[$rk]['panels'][$k]['data'] = db_select('*', 'login_shortcuts', "(id_user=$ruser[id] OR id_role=$ruser[role]) AND public='Y'", 'ordine');
        }
