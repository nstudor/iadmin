<?php 
    $APP_DB_LINK = 0;
    
    $MESSAGE='';
    
    function db_connect() {   
        global $APP_DB_SERVER, $APP_DB_USER, $APP_DB_PASS, $APP_DB_NAME, $APP_DB_LINK, $MESSAGE;
        $APP_DB_LINK = mysqli_connect( $APP_DB_SERVER, $APP_DB_USER, $APP_DB_PASS, $APP_DB_NAME);        
        if(!$APP_DB_LINK) $MESSAGE = mysqli_connect_error();
        return (bool)$APP_DB_LINK;
    }

/** Creating new database data ( login & initial setup )
 * 
 */
    function db_initialize() {      
        global $APP_DB_LINK, $MESSAGE;
        $txt= file_get_contents('../connector/mySQL.init.sql');
        $txt=explode("\n\n",$txt);        
        foreach($txt as $sql) if($MESSAGE=='') {
            mysqli_query($APP_DB_LINK, $sql);
            if (mysqli_connect_errno($APP_DB_LINK)) { $MESSAGE = mysqli_connect_error($APP_DB_LINK); }
            echo $MESSAGE;
        }        
        return ($MESSAGE == '');
    }

?>