<?php 
    unset($_SESSION['filter']);
    unset($_SESSION['filtertype']);
    $panelRows=db_select('DISTINCT rand', 'login_dashboard', 'id_user='.$ruser['id'], 'rand');
    foreach($panelRows as $k=>$v) {
        $panelRows[$k]['panels']=db_select('*', 'login_dashboard', 'id_user='.$ruser['id'].' AND `rand`='.$v['rand'], 'ordine');
    }
?>