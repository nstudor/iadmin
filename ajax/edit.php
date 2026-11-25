<?php
$oper = $pp[1];
$k = $pp[2];
if (!isset($id)) $id = 'id';
if (!array_key_exists($k, $fields)) die(showMessage('Invalid field !', 'danger'));
$r = db_select('*', $tabel, "$id='" . db_esc($pp[3] ?? '') . "'")[0] ?? [];
?>
<form action="./<?php echo $oper ?>-edit-id-<?= htmlspecialchars((string)($r[$id] ?? '')) ?>.htm" method="post" name="ff" enctype="multipart/form-data">
    <?php
    fieldFormat($k, $fields[$k], $r[$k] ?? '', 'edit', '../', $r[$id] ?? 0, $oper);
    ?>
    <div class="row panel-submit" style="margin-top: 10px;">
        <div class="col">&nbsp;</div>
        <div class="col">&nbsp;</div>
        <div class="col"><button type="button" class="btn btn-primary spc" onclick="document.ff.submit()" style="width: 100%">Ok</button></div>
    </div>
</form>