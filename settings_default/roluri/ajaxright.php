<?php 
    $fields=array(
            'v'=>'view_right',
            'a'=>'add_right',
            'm'=>'modify_right',
            'd'=>'delete_right',
    );
    $item=db_select('*', 'login_rights', "id_role=$_GET[idu] AND id_menu=$_GET[idd]")[0];
    if(!isset($item[$fields[$_GET['tip']]]))
        db_insert(
            [
                'id_role'=>$_GET[idu],
                'id_menu'=>$_GET[idd],
                $fields[$_GET['tip']]=>'Y'
            ], 'login_rights');
        else
        db_update(
            [ $fields[$_GET['tip']] => ($item[$fields[$_GET['tip']]]=='Y'?'N':'Y') ], 
            'login_rights', 
            "id_role='$_GET[idu]' AND id_menu='$_GET[idd]'");
?><button class="btn btn-<?php echo ($item[$fields[$_GET['tip']]]=='Y'?'danger':'success'); ?> spc" onclick="butonat(<?php echo $_GET['idd'] ?>,'<?php echo $_GET['tip'] ?>')">O</button>