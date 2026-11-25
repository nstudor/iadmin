<?php
$hasNoTable = 1;
$scriptPage = "page";
$ipage = db_select('*', "login__pages", "slug='index' AND public='B'")[0]['content'] ?? '[[content]]';
$slug = implode('-', array_slice($param, 1));
$page = db_select('*', "login__pages", "slug='" . db_esc($slug) . "' AND public='Y'")[0] ?? null;

// unknown page (for example a module URL opened while logged out): show the login page instead
if (!$page && $slug != 'login')
    $page = db_select('*', "login__pages", "slug='login' AND public='Y'")[0] ?? null;

if (!$page) {
    $scriptPage = '404';
    $page = ['title' => '', 'content' => ''];
    return;
}

$page['content'] = (string)($page['content'] ?? '');
$rep = [];

if (str_contains($page['content'], "[LOGINFORM]")) {
    $loginform = db_select('*', "login__pages", "slug='loginform' AND public='B'")[0]['content'] ?? '';
    $page['content'] = str_replace("[LOGINFORM]", $loginform, $page['content']);

    $rep += array(
        "[sign_in_title]" => t('sign_in_title'),
        "[sign_in_username]" => t('sign_in_username'),
        "[sign_in_password]" => t('sign_in_password'),
        "[sign_in_button]" => t('sign_in_button'),
        "[sign_in_recover]" => t('sign_in_recover'),
        "[sign_in_message]" => $MESSAGE != '' ? showMessage($MESSAGE, 'danger') : "",
    );
}

if (str_contains($page['content'], "[recover_email]")) {
    $rep += array(
        "[recover_email]" => t('recover_email'),
        "[recover_button]" => t('recover_button'),
    );
}

$page['content'] = str_replace(array_keys($rep), $rep, $page['content']);

$page['title'] = '';
$page['content'] = str_replace('[[content]]', $page['content'], $ipage);
