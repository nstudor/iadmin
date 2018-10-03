<?php
    if(count($_POST['item'])>0) {
        if(db_insert($_POST['item'], $tabel))
            die("<script>document.location='./tabel-$param[1].htm';</script>");
        else {
            echo showMessage($MESSAGE, 'danger');
            die;
        }
    }    
?>