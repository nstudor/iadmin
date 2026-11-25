<?php 
    foreach($_SESSION as $k=>$v) unset($_SESSION[$k]);
    session_destroy();
    $hasNoTable=1;
    $scriptPage="logout";
?>