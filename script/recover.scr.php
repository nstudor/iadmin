<?php
if (isset($_POST['email'])) {
    $item = db_select('*', 'login_users', 'email="' . $_POST['email'] . '"')[0];
    if ($item['id'] > 0) {
        $content = file_get_contents('template/' . $APP_TEMPLATE . '/recover.htm');
        $mailArray = [
            'to' => $_POST['email'],
            'subject' => 'Recovering password for ' . $APP_NAME,
            'message' => $content,
        ];
        $link = str_replace(
            '/recover.',
            '/newpass-' . md5($item['email']) . '-' . md5($item['id']) . '.',
            $_SERVER['HTTP_ORIGIN'] . $_SERVER['REQUEST_URI']
        );
        $mailArray['message'] = str_replace('[LINK]', $link, $mailArray['message']);
        sendMail($mailArray);
        echo showMessage('Recovery email sent !', 'info');
    } else {
        echo showMessage('Email address not found !', 'danger');
    }
}
