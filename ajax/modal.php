<?php 
    ini_set('session.bug_compat_warn', 0);
    ini_set('session.bug_compat_42', 0);
    error_reporting(0);
    session_start();
    include('../settings.ini');
    include('../utils.php');
    if(file_exists('../lang/' . $APP_LANGUAGE . '.lng.php')) {
        include('../lang/' . $APP_LANGUAGE . '.lng.php');
    }
    include('../connector/'.$APP_DB_TYPE.'.con.php');        
    db_connect();
    $pp=explode('-',$_GET['p']);
    if(file_exists("$pp[0].php")) include("$pp[0].php"); else include("404.php");
?>