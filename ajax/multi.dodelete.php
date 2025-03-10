<?php

if (db_drop("$pp[3] IN ('" . implode("', '", $ids) . "')", $tabel))
    die("<script>document.location=document.location;</script>");
else {
    echo showMessage($MESSAGE, 'danger');
    die;
}
