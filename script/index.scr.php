<?php 
    if(isset($_SESSION['userid'])) {
        $ruser = db_select('*', 'login_users', 'id='.$_SESSION['userid'])[0];        
        $link = $param[0]; if(!empty($param[1])) $link != "-$param[1]";
        $rcmenu=db_select('*', 'login_menu', "link='$link'")[0];

        $rcr=db_select('*','login_rights', 'id_menu='.($rcmenu['id']*1).' AND id_role='.$ruser['role'])[0];
        $rcr['details_v']=explode(" ",$rcr['details_v']);
        $rcr['details_a']=explode(" ",$rcr['details_a']);
        $rcr['details_m']=explode(" ",$rcr['details_m']);
        $rcr['details_d']=explode(" ",$rcr['details_d']);
        $_SESSION['rights']=$rcr;
        
        if(isset($_SESSION['menudata'])) $menu=$_SESSION['menudata']; else {
            $menu=[];
            $re=db_select('*', 'login_menu', 'id!=0', 'ordine');
            if($re) {
                foreach($re as $r)
                    {
                        $menu[$r['id']]=$r;
                        $rd=db_select('*', 'login_rights', 'id_menu='.$r['id']." AND id_role=".$ruser['role'])[0];
                        $ok=false;
                        if($r['right']=='Y') $ok=true;
                        if($rd['view_right']=='Y') $ok=true;
                        $menu[$r['id']]['ok']=$ok;
                    }
                foreach($menu as $m) if((!$menu[$m['id_tata']]['ok'])&&($m['ok'])&&($m['right']!='Y')) $menu[$m['id_tata']]['ok']=true;
                foreach($menu as $m) if((!$menu[$m['id_tata']]['ok'])&&($m['ok'])&&($m['right']!='Y')) $menu[$m['id_tata']]['ok']=true;
                foreach($menu as $k=>$m) if(!$m['ok']) unset($menu[$k]);
                $_SESSION['menudata']=$menu;
            } else showMessage("Access denied: ".$MESSAGE, 'danger');
        }
    }
?>