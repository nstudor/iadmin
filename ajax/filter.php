<?php session_start(); $oper=$pp[1]; $k=$pp[2]; ?>
<form action="./tabel-<?php echo $oper ?>.htm" method="post" name="ff">
<input name="fld" type="hidden" value="<?php echo $k ?>" />
<?php 
    $fType= is_array($fields[$k])?$fields[$k]['type']:'text';    
    if(file_exists("../settings/$oper/{$k}_filter.php"))
        include("../settings/$oper/{$k}_filter.php"); 
    else 
        include("../fieldtypes/".$fType."_filter.type.php"); ?>
</form>
