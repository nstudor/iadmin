<?php 
    $APP_DB_LINK = NULL;
    
    $MESSAGE='';
    
    function db_connect() {   
        global $APP_DB_SERVER, $APP_DB_USER, $APP_DB_PASS, $APP_DB_NAME, $APP_DB_PORT, $APP_DB_LINK, $MESSAGE;
        $APP_DB_LINK = mysqli_connect( $APP_DB_SERVER, $APP_DB_USER, $APP_DB_PASS, $APP_DB_NAME, $APP_DB_PORT);
        if(!$APP_DB_LINK) $MESSAGE = mysqli_connect_error();
        mysqli_query($APP_DB_LINK, "SET NAMES utf8");
        return (bool)$APP_DB_LINK;
    }

/** Creating new database data ( login & initial setup )
 * 
 */
    function db_initialize() {      
        global $APP_DB_LINK, $MESSAGE;
        $txt= file_get_contents('../connector/mySQL.init.sql');

        $txt= str_replace('[[USER]]', $_POST['iUser'], $txt);
        $txt= str_replace('[[PASS]]', md5($_POST['iPass']), $txt);
        
        $txtArr=explode("\n\n",$txt);  
        if(count($txtArr)) $txtArr=explode("\r\n\r\n",$txt);
        
        foreach($txtArr as $sql) if($MESSAGE=='') {
            mysqli_query($APP_DB_LINK, $sql);
            if (mysqli_connect_errno($APP_DB_LINK)) { $MESSAGE = mysqli_connect_error($APP_DB_LINK); }
            echo $MESSAGE;
        }        
        return ($MESSAGE == '');
    }

    function db_select($what, $table, $where='1', $order = NULL, $limit=NULL, $keyField = NULL) {
        global $APP_DB_LINK, $MESSAGE;
        $ret=[];
        if(is_array($what)) $what='`'.implode('`, `', $what).'`';
        if( !empty($order) ) $order = ' ORDER BY '.$order;     
        if( !empty($limit) ) $limit = ' LIMIT '.$limit;        
        $re=mysqli_query($APP_DB_LINK, "SELECT $what FROM $table WHERE $where$order$limit");
        
        if( mysqli_errno ( $APP_DB_LINK ) )
        {
            $MESSAGE = mysqli_error( $APP_DB_LINK )."<br>SELECT $what FROM $table WHERE $where$order$limit";
            $ret = NULL;
        } else {
            while($r=mysqli_fetch_assoc( $re )) 
            {
                if(empty($keyField)) 
                {
                    $ret[]=$r;
                } else {
                    $ret[$r[$keyField]]=$r;
                }
            }
        }
        return $ret;
    }


    function db_update($what, $table, $where) {
        global $APP_DB_LINK, $MESSAGE;
        
        $upd=[];
        foreach($what as $k=>$v)
        {
            $upd[] = "`$k`='".addslashes($v)."'";
        }
        
        mysqli_query($APP_DB_LINK, "UPDATE $table SET " . implode(', ', $upd) . " WHERE $where");
       
        if( mysqli_errno ( $APP_DB_LINK ) )
        {
            $MESSAGE = mysqli_error( $APP_DB_LINK );
            return FALSE;
        }
        return TRUE;
    }
    
    function db_insert($what, $table) {
        global $APP_DB_LINK, $MESSAGE;
        $query = "INSERT INTO $table (`" . implode('`, `', array_keys($what)) . 
                "`) VALUES ('" . implode("', '", $what) . "')";
        mysqli_query($APP_DB_LINK, $query);
        if( mysqli_errno ( $APP_DB_LINK ) )
        {
            $MESSAGE = mysqli_error( $APP_DB_LINK );
            return FALSE;
        }
        return mysqli_insert_id($APP_DB_LINK);
    }
    
    function db_drop($where, $table) {
        global $APP_DB_LINK, $MESSAGE;
        
        mysqli_query($APP_DB_LINK, "DELETE FROM $table WHERE $where");
       
        if( mysqli_errno ( $APP_DB_LINK ) )
        {
            $MESSAGE = mysqli_error( $APP_DB_LINK );
            return FALSE;
        }
        return TRUE;
    }
?>
