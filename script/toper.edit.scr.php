<?php
    if(count($_POST['item'])>0) {
        db_update($_POST['item'], $tabel, "$id=".$get[$id]);
        die("<script>document.location='./tabel-$param[1].htm';</script>");
    }    
?>