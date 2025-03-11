<?php 
    foreach($_SESSION as $k=>$v) unset($_SESSION[$k]);
    $hasNoTable=1;
    $scriptPage="logout";
?>