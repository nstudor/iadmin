<?php 
    ini_set('session.bug_compat_warn', 0);
    ini_set('session.bug_compat_42', 0);
    error_reporting(0);
    session_start();    
    include('utils.php');
        
    if(file_exists('settings.ini')) {
        
        include('settings.ini');
 
        include('lang/english.lng.php');
        $_DEFLNG=$_LNG;
        if(file_exists('lang/' . $APP_LANGUAGE . '.lng.php')) {
            include('lang/' . $APP_LANGUAGE . '.lng.php');
        }

        include('connector/'.$APP_DB_TYPE.'.con.php');        
        
        db_connect();
        
        if(isset($_POST['log_user']))
	{
            $MESSAGE='Utilizator inexistent';
            $user=db_select('*', 'login_users', "user='".$_POST['log_user']."'")[0];            
            if($user['pass']==md5($_POST['log_pass'])) 
            {
                $_SESSION['userid']=$user['id'];
                db_update(array('logtime'=>date("Y-m-d H:i:s")), "login_users", "id=".$user['id']);
                $MESSAGE='';
                ?><script type="text/javascript">document.location="./"; </script><?php
            } else if(isset($user['pass'])) $MESSAGE='Parola gresita';
        }
        
        if(isset($_GET['p'])) {
            $param=explode("-",$_GET['p']);
        } else {            
            $param=array('dashboard');
        }  

        if(!isset($_SESSION['userid'])) {
            $param=array('login',$param[0]);
        }
        
        include('script/index.scr.php');        

        if(file_exists('script/'.$param[0].'.scr.php')) {
            include('script/'.$param[0].'.scr.php');
        }
        
        if(!file_exists('template/' . $APP_TEMPLATE . '/'.$param[0].'.tpl.php')) $param[0]='404';
        
        include('template/' . $APP_TEMPLATE . '/index.tpl.php');        
        
    } else {
        header('Location: ./setup/');
    }

?>
