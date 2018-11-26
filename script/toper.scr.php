<?php
    $pag=$param[1];	
    $id='id';
    $settingFile="settings/$pag/config.php";
    if(!file_exists($settingFile)) $settingFile="settings_default/$pag/config.php";
    
    if( file_exists($settingFile) )
    {
        include($settingFile);       
        $addfields=$fields;
        foreach($addfields as $k=>$v) if(is_array($v)) if($v['noAdd']) unset($addfields[$k]);
        $editfields=$fields;
        foreach($editfields as $k=>$v) if(is_array($v)) if($v['noEdit']) unset($editfields[$k]);
    } else {
        include("404.php");die("</body></html>");        
    }        
    
    $get=[];
    for($i=3;$i<count($param);$i+=2) $get[$param[$i]]=$param[$i+1];

    $item=db_select('*', $tabel, "$id=$get[id]")[0];     

    if(file_exists("script/toper.$param[2].scr.php")) {
        include("script/toper.$param[2].scr.php");
    } 
?>