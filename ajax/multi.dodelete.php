<?php

if (db_drop("$id IN ('" . implode("', '", array_map('db_esc', $ids)) . "')", $tabel))
    die("<script>document.location=document.location;</script>");
else {
    echo showMessage($MESSAGE, 'danger');
    die;
}
