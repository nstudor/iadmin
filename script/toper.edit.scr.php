<?php
if (isset($_POST['item']))
    if (count($_POST['item']) > 0) {
        //        print_r($_FILES); die();
        foreach ($_FILES['file']['name'] as $k => $v) {
            if (isset($fields[$k])) {
                $fileName = $v;
                $tempName = $_FILES['file']['tmp_name'][$k];
                if ($_FILES['file']['error'][$k] == 0)
                    include("fieldtypes/" . $fields[$k]['type'] . ".process.php");
                else $MESSAGE = "Error uploading file !";
            }
        }
        db_update($_POST['item'], $tabel, "$id=" . $get[$id]);
        die("<script>document.location='./tabel-$param[1].htm';</script>");
    }
