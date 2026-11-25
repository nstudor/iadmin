<?php
// selected day: ?data=YYYY-MM-DD, default today
$calDay = strtotime($_GET['data'] ?? 'today') ?: strtotime('today');
foreach ($panelRows as $rk => $rv)
    foreach ($rv['panels'] as $k => $v)
        if ($v['fisier'] == 'calendar') {
            $panelRows[$rk]['panels'][$k]['data'] = [
                'dd' => $calDay,
                'an' => date("Y", $calDay),
                'lu' => date("m", $calDay),
                'zi' => date("d", $calDay),
                'crt' => date("Y-m-d", $calDay) == date("Y-m-d"),
            ];
        }
