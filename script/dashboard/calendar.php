<?php
foreach ($panelRows as $rk => $rv)
    foreach ($rv['panels'] as $k => $v)
        if ($v['fisier'] == 'calendar') {
            $panelRows[$rk]['panels'][$k]['data']['dd'] = strtotime(isset($_GET['data'])?$_GET['data']:"now");
            $panelRows[$rk]['panels'][$k]['data']['an'] = date("Y",$panelRows[$rk]['panels'][$k]['data']['dd']);       
            $panelRows[$rk]['panels'][$k]['data']['lu'] = date("m",$panelRows[$rk]['panels'][$k]['data']['dd']);
            $panelRows[$rk]['panels'][$k]['data']['zi'] = date("d",$panelRows[$rk]['panels'][$k]['data']['dd']);
            $panelRows[$rk]['panels'][$k]['data']['crt'] = (date("Y-m-d",$panelRows[$rk]['panels'][$k]['data']['dd'])==date("Y-m-d",strtotime(date("Y-m-",$panelRows[$rk]['panels'][$k]['dd']).date("j"))));
        }
