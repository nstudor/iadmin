<?php
if (isset($_POST['item']))
    if (count($_POST['item']) > 0) {
        $MESSAGE = '';
        foreach ($_FILES['file']['name'] ?? [] as $k => $v) {
            if (isset($fields[$k])) {
                $fileName = $v;
                $tempName = $_FILES['file']['tmp_name'][$k];
                if ($_FILES['file']['error'][$k] == 0)
                    include("fieldtypes/" . $fields[$k]['type'] . ".process.php");
                else $MESSAGE = t('upload_error');
            }
        }
        $newId = false;
        if ($MESSAGE == '')
            $newId = db_insert(db_only($_POST['item'], array_keys($addfields)), $tabel);
        if ($newId) {
            $id = $newId;
            // optional module hook after a successful insert ($id = new row id)
            if (file_exists("settings/$pag/add.php")) include("settings/$pag/add.php");
            elseif (file_exists("settings_default/$pag/add.php")) include("settings_default/$pag/add.php");
            if (file_exists("settings/$pag/new.php"))
                die("<script>document.location='./$param[0]-new-$id.htm';</script>");
            else
                die("<script>document.location='./$param[0].htm';</script>");
        } else {
            echo showMessage($MESSAGE, 'danger');
            die;
        }
    }