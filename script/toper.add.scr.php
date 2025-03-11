<?php
if (isset($_POST['item']))
    if (count($_POST['item']) > 0) {
        $MESSAGE = '';
        foreach ($_FILES['file']['name'] as $k => $v) {
            if (isset($fields[$k])) {
                $fileName = $v;
                $tempName = $_FILES['file']['tmp_name'][$k];
                if ($_FILES['file']['error'][$k] == 0)
                    include("fieldtypes/" . $fields[$k]['type'] . ".process.php");
                else $MESSAGE = "Error uploading file !";
            }
        }
        if ($MESSAGE == '')
            $id = db_insert($_POST['item'], $tabel);
        if ($id)
            if (file_exists("settings/$pag/new.php"))
                die("<script>document.location='./$param[0]-new-$id.htm';</script>");
            else
                die("<script>document.location='./$param[0].htm';</script>");
        else {
            echo showMessage($MESSAGE, 'danger');
            die;
        }
    }