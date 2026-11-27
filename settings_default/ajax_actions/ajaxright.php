<?php
    $fields=array(
            'v'=>'view_right',
            'a'=>'add_right',
            'm'=>'modify_right',
            'd'=>'delete_right',
    );
    $idu = (int)($_GET['idu'] ?? 0);
    $idd = (int)($_GET['idd'] ?? 0);
    $tip = $_GET['tip'] ?? '';
    if (!isset($fields[$tip])) die(showMessage(t('invalid_right'), 'danger'));
    $col = $fields[$tip];
    $item=db_select('*', 'login__rights', "id_role=$idu AND id_menu=$idd")[0] ?? [];
    if(!isset($item[$col]))
        db_insert(
            [
                'id_role'=>$idu,
                'id_menu'=>$idd,
                $col=>'Y'
            ], 'login__rights');
        else
        db_update(
            [ $col => ($item[$col]=='Y'?'N':'Y') ],
            'login__rights',
            "id_role=$idu AND id_menu=$idd");
?><button class="btn btn-<?php echo (($item[$col] ?? '')=='Y'?'danger':'success'); ?> spc" onclick="butonat(<?php echo $idd ?>,'<?php echo $tip ?>')">O</button>
