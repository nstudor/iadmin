<?php
    $pag=$param[1];	
    $id='id';
    if(file_exists("settings/$pag/config.php"))
        include("settings/$pag/config.php"); 
    else {
        include("404.php");die("</body></html>");        
    }        
    
    $get=[];
    for($i=3;$i<count($param);$i+=2) $get[$param[$i]]=$param[$i+1];

    $item=db_select('*', $tabel, "$id=$get[id]")[0];     

    if(file_exists("script/toper.$param[2].scr.php")) {
        include("script/toper.$param[2].scr.php");
    } 
?>