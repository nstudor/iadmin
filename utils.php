<?php

    function showMessage($msg, $type = 'success', $print = 0, $icon = 1 ) {

        if( $icon ) {
            // TODO: SHOW ICON STUFF
        }
            
        $txt='<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';
        
        if( $print ) echo $txt;
        
        return $txt;        
        
    }
    function printr($x ) {
        echo "<pre>";
        print_r($x);
        echo "</pre>";        
    }
    
    function fieldFormat($fieldDef, $fieldValue) {
        $type=( empty($fieldDef['type']) ? 'text' : $fieldDef['type'] );
        include("fieldtypes/$type.type.php");
    }
?>