<?php
session_start();
$oper = $pp[1];
$k = $pp[2];
include("../settings/$oper/config.php");
if (!isset($id)) $id = 'id';
$r = db_select('*', $tabel, "$id=$pp[3]")[0];
?>
<form action="./toper-<?php echo $oper ?>-edit-id-<?= $pp[3] ?>.htm" method="post" name="ff" enctype="multipart/form-data">
    <?php
    fieldFormat($k, $fields[$k], $r[$k], 'edit', '../', $r[$id], $oper);
    ?>
    <div class="row panel-submit" style="margin-top: 10px;">
        <div class="col">&nbsp;</div>
        <div class="col">&nbsp;</div>
        <div class="col"><button type="button" class="btn btn-primary spc" onclick="document.ff.submit()" style="width: 100%">Ok</button></div>
    </div>
</form>