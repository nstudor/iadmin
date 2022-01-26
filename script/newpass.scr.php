<?php
$p = explode("-", $_GET['p']);
$item = db_select('*', 'login_users', 'md5(email)="' . $p[1] . '" AND md5(id)="' . $p[2] . '"')[0];
if ($item['id'] > 0) {
    $_SESSION['rights']['modify_right'] = 'Y';
    $param = [
        'toper',
        'utilizatori',
        'key',
        'id',
        $item['id']
    ];
}
