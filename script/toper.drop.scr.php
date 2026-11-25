<?php
    if((($_POST['item'] ?? '') == 1) && isset($get['id'])) {
        if(db_drop("$id='" . db_esc($get['id']) . "'", $tabel))
            die("<script>document.location='./$param[0].htm';</script>");
        else {
            echo showMessage($MESSAGE, 'danger');
            die;
        }
    }
    
    if($noDropConfirm) {
?>
<form action="" method="post" name="dropform" >
<input type="hidden" name="item" value="1" />
<input type="hidden" name="_csrf" value="<?= csrf_token() ?>" />
</form>    
<script>document.dropform.submit();</script>
<?php } ?>
