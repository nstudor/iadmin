<?php    
    $item=db_select('*', $tabel, "$id=$pp[3]")[0];
    $k=$pp[2];
?>
<input name="field" type="hidden" value="<?php echo $k ?>" id="ajaxfield" />
<input name="ajaxid" type="hidden" value="<?php echo $pp[3]?>" id="ajaxid" />
<?php 	
    if(file_exists("../settings/$pag/{$k}_edit.php")) include("../settings/$pag/{$k}_edit.php"); 
        else fieldFormat($k, $fields[$k], $item[$k], 'edit'); ?>