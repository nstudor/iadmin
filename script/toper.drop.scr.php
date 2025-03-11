<?php
    if($_POST['item']==1) {
        if(db_drop("$param[2]=$param[3]", $tabel))
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
</form>    
<script>document.dropform.submit();</script>
<?php } ?>
