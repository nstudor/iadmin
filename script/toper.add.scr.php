<?php
    if(count($_POST['item'])>0) {
        $id=db_insert($_POST['item'], $tabel);
        if($id)
            if(file_exists("settings/$pag/new.php"))
                die("<script>document.location='./toper-$param[1]-new-$id.htm';</script>");
            else
                die("<script>document.location='./tabel-$param[1].htm';</script>");                
        else {
            echo showMessage($MESSAGE, 'danger');
            die;
        }
    }    
?>