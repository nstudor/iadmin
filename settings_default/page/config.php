<?php
$hasNoTable = 1;
$scriptPage = "page";
$page = db_select('*', "login_pages", "slug='" . implode('-', array_slice($param, 1)) . "' AND public='Y'")[0];


if (strpos($page['content'], "[LOGINFORM]")) {
    $x = file_get_contents("static/login.htm");
    $page['content'] = str_replace("[LOGINFORM]", $x, $page['content']);
    $page['content'] = str_replace("[sign_in_title]", t('sign_in_title'), $page['content']);
    $page['content'] = str_replace("[sign_in_username]", t('sign_in_username'), $page['content']);
    $page['content'] = str_replace("[sign_in_password]", t('sign_in_password'), $page['content']);
    $page['content'] = str_replace("[sign_in_button]", t('sign_in_button'), $page['content']);
    $page['content'] = str_replace("[sign_in_recover]", t('sign_in_recover'), $page['content']);
    $page['content'] = str_replace("[sign_in_message]", $MESSAGE != ''?showMessage($MESSAGE, 'danger'):"", $page['content']);
}

// Array ( [id] => 1 [slug] => bla-bla [title] => 1 [content] => 2 [ordine] => 3 [public] => Y )
