<?php
    if(file_exists('template/' . $APP_TEMPLATE . '/'.$param[0]. '.'.$param[2].'.tpl.php'))
        include('template/' . $APP_TEMPLATE . '/'.$param[0]. '.'.$param[2].'.tpl.php');
        else
        if(file_exists('settings/' . $param[1]. '/'.$param[2].'.php'))
            include('settings/' . $param[1]. '/'.$param[2].'.php');
            else
            if(file_exists('settings_default/' . $param[1]. '/'.$param[2].'.php'))
                include('settings_default/' . $param[1]. '/'.$param[2].'.php');
            else
            include('ajax/404.php');
?>
