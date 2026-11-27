<?php
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
error_reporting(0);
session_start();
if (empty($_SESSION['userid'])) {
    http_response_code(403);
    exit;
}
include('../settings.ini');
include('../utils.php');
include('../lang/english.lng.php');
$_DEFLNG = $_LNG;
if (file_exists('../lang/' . $APP_LANGUAGE . '.lng.php')) {
    include('../lang/' . $APP_LANGUAGE . '.lng.php');
}
// every modal request (GET or POST) must carry the session CSRF token
if (!csrf_ok()) {
    http_response_code(403);
    die(showMessage(t('invalid_token'), 'danger'));
}
include('../connector/' . $APP_DB_TYPE . '.con.php');
db_connect();
$pp = explode('-', $_GET['p']);

$pag = $pp[1] ?? '';
// module names may only contain lowercase letters, digits and "_"
if (!preg_match('/^[a-z0-9_]+$/', $pag)) {
    include('404.php');
    exit;
}
// rights of the module, always from the DB
// filter / export -> view, edit / medit / mdoedit -> modify,
// multi delete / dodelete -> delete, other multi and custom actions -> modify
$action = $pp[0];
$actionRights = ['filter' => 'view_right', 'export' => 'view_right', 'edit' => 'modify_right', 'medit' => 'modify_right', 'mdoedit' => 'modify_right'];
if ($action == 'multi') $needRight = in_array($pp[2] ?? '', ['delete', 'dodelete'], true) ? 'delete_right' : 'modify_right';
else $needRight = $actionRights[$action] ?? 'modify_right';
$rcr = load_rights($pag);
if (!has_right($rcr, $needRight)) {
    http_response_code(403);
    die(showMessage(t('access_denied'), 'danger'));
}

$id = 'id';
$settingFile = "../settings/$pag/config.php";
if (!file_exists($settingFile)) $settingFile = "../settings_default/$pag/config.php";
include($settingFile);

// Core actions live in ajax/; any other action must be a plain name and is
// looked up in settings/ajax_actions/, then settings_default/ajax_actions/.
$coreActions = ['filter', 'edit', 'medit', 'mdoedit', 'multi', 'export'];
$actionFile = '404.php';
if (in_array($action, $coreActions, true)) {
    $actionFile = "$action.php";
} elseif (preg_match('/^[A-Za-z0-9_]+$/', $action)) {
    if (file_exists("../settings/ajax_actions/$action.php"))
        $actionFile = "../settings/ajax_actions/$action.php";
    elseif (file_exists("../settings_default/ajax_actions/$action.php"))
        $actionFile = "../settings_default/ajax_actions/$action.php";
}
include($actionFile);
