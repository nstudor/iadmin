<?php 
    ini_set('session.bug_compat_warn', 0);
    ini_set('session.bug_compat_42', 0);
    error_reporting(0);
    session_start();
    
    if(file_exists('settings.ini')) {
        
        include('settings.ini');
        
        include('connector/'.$DBTYPE.'.con.php');        
        
        if(isset($_GET['p'])) {
            $param=explode("-",$_GET['p']);
        } else {            
            $param=array('');
        }  
        
        if(!isset($_SESSION['userid'])) {
            $param=array('login');
        }   
        
        if(file_exists('script/'.$param[1].'.scr.php')) {
            include('script/'.$param[1].'.scr.php');
        }
        
        include('script/index.scr.php');        
        include('template/'.$TEMPLATE.'/index.scr.php');        
        
    } else {
        header('Location: ./setup/');
    }
/*
include("defines.php");
if(isset($_GET['p'])) $param=explode("-",$_GET['p']); else $param=array('');
if(isset($_POST['log_user']))
	{
		$err='Utilizator inexistent';
		$user=@mysql_fetch_array(mysql_query("SELECT * FROM login_users WHERE user='".$_POST['log_user']."'"));		
		if($user['pass']==md5($_POST['log_pass'])) 
			{
				$_SESSION['userid']=$user['id'];
				mysql_query("UPDATE login_users SET logtime=now() WHERE id=".$user['id']);
				$err='';
				?><script type="text/javascript">document.location="./"; </script><?php
			} else if(isset($user['pass'])) $err='Parola gresita';
	}
if($param[0]=='logout')
			{
				foreach($_SESSION as $k=>$v) unset($_SESSION[$k]);
				?><script type="text/javascript"> document.location="./"; </script><?php
			};			
if(isset($_SESSION['userid'])) include("main.php"); else include("login.php");
//print_r($_SESSION);
*/
?>