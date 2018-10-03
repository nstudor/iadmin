<?php 
    $pag=$pp[1];
    $id='id';
    include("../settings/$pag/config.php");
    
    db_update([$_POST['field']=>$_POST['item']], $tabel, "$id=$_POST[id]");  
    
    $r=db_select('*', $tabel, "$id=$_POST[id]")[0];
    $k=$_POST['field'];
    if(file_exists("../settings/$pag/{$k}_show.php")) include("../settings/$pag/{$k}_show.php"); 
        else fieldFormat($k, $fields[$k], $r[$k], '', '../');
?>