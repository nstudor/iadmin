<?php
$oper = $pp[1];
$k = $pp[2];
if (!isset($id)) $id = 'id';
if (!array_key_exists($k, $fields)) die(showMessage(t('invalid_field'), 'danger'));
$r = db_select('*', $tabel, "$id='" . db_esc($pp[3] ?? '') . "'")[0] ?? [];
// optional per-field hook: may set $extra (HTML shown next to the Ok button), e.g. helper buttons
$extra = '&nbsp;';
if (file_exists("../settings/$pag/{$k}_medit.php")) include("../settings/$pag/{$k}_medit.php");
elseif (file_exists("../settings_default/$pag/{$k}_medit.php")) include("../settings_default/$pag/{$k}_medit.php");
?>
<form action="./<?php echo $oper ?>-edit-id-<?= htmlspecialchars((string)($r[$id] ?? '')) ?>.htm" method="post" name="ff" enctype="multipart/form-data">
    <?php
    fieldFormat($k, $fields[$k], $r[$k] ?? '', 'edit', '../', $r[$id] ?? 0, $oper);
    ?>
    <div class="row panel-submit" style="margin-top: 10px;">
        <div class="col col-8"><?= $extra ?></div>
        <div class="col col-4"><button type="button" class="btn btn-primary spc" onclick="document.ff.submit()" style="width: 100%"><?= t('ok') ?></button></div>
    </div>
</form>