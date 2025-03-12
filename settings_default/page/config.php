<?php
$hasNoTable = 1;
$scriptPage = "page";
$ipage = db_select('*', "login_pages", "slug='index' AND public='B'")[0]['content'];
$page = db_select('*', "login_pages", "slug='" . implode('-', array_slice($param, 1)) . "' AND public='Y'")[0];

if (strpos($page['content'], "[LOGINFORM]")) {
    $loginform = db_select('*', "login_pages", "slug='loginform' AND public='B'")[0]['content'];
    $page['content'] = str_replace("[LOGINFORM]", $loginform, $page['content']);

    $rep = array(
        "[sign_in_title]" => t('sign_in_title'),
        "[sign_in_username]" => t('sign_in_username'),
        "[sign_in_password]" => t('sign_in_password'),
        "[sign_in_button]" => t('sign_in_button'),
        "[sign_in_recover]" => t('sign_in_recover'),
        "[sign_in_message]" => $MESSAGE != '' ? showMessage($MESSAGE, 'danger') : "",
    );
}

if (strpos($page['content'], "[recover_email]")) {
    $rep = array(
        "[recover_email]" => t('recover_email'),
        "[recover_button]" => t('recover_button'),
    );
}

$page['content'] = str_replace(array_keys($rep), $rep, $page['content']);

$page['title']='';
$page['content'] = str_replace('[[content]]', $page['content'], $ipage);
