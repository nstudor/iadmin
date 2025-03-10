<?php
$item = db_select('*', $tabel, "$id=$pp[3]")[0];
$k = $pp[2];
if (!is_array($fields[$k]))
    $fields[$k] = [
        'name' => $fields[$k]
    ];
$fields[$k]['uri'] = $pp[1];
$fields[$k]['rowId'] = $pp[3];
?>
<input name='field' type='hidden' value="<?php echo $k ?>" id='ajaxfield' />
<input name='ajaxid' type='hidden' value="<?php echo $pp[3] ?>" id='ajaxid' />
<?php
if (file_exists("../settings/$pag/{$k}_edit.php")) include("../settings/$pag/{$k}_edit.php");
else fieldFormat($k, $fields[$k], $item[$k], 'edit');
?>