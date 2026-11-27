<?php
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
error_reporting(0);
session_start();
include('utils.php');

if (file_exists('settings.ini')) {

    include('settings.ini');
    if($DEBUG_MODE ?? false) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
    include('lang/english.lng.php');
    $_DEFLNG = $_LNG;
    if (file_exists('lang/' . $APP_LANGUAGE . '.lng.php')) {
        include('lang/' . $APP_LANGUAGE . '.lng.php');
    }
    include('connector/' . $APP_DB_TYPE . '.con.php');

    db_connect();

    // every POST of a logged-in user must carry the session CSRF token
    if (isset($_SESSION['userid']) && $_SERVER['REQUEST_METHOD'] == 'POST' && !csrf_ok()) {
        http_response_code(403);
        die(showMessage(t('invalid_token'), 'danger'));
    }

    if (isset($_POST['log_user'])) {
        $MESSAGE = t('login_unknown_user');
        $user = db_select('*', 'login__users', "user='" . db_esc($_POST['log_user']) . "'")[0] ?? null;
        if ($user && password_check($_POST['log_pass'] ?? '', $user['pass'])) {
            session_regenerate_id(true);
            unset($_SESSION['csrf'], $_SESSION['menudata']);
            $_SESSION['userid'] = $user['id'];
            db_update(array('logtime' => date("Y-m-d H:i:s")), "login__users", "id=" . (int)$user['id']);
            $MESSAGE = '';
?>
            <script type="text/javascript">
                document.location = "./";
            </script>
<?php
        } else if ($user) $MESSAGE = t('login_wrong_password');
    }

    if (isset($_GET['p'])) {
        $param = explode("-", $_GET['p']);
    } else {
        $param = array('home');
    }
    if (!isset($_SESSION['userid'])) {
        if ($param[0] == 'home')
            $param = array('page', 'login');
        else
            array_unshift($param, 'page');
    }

    $pag = $param[0];
    // module names may only contain lowercase letters, digits and "_"
    if (!preg_match('/^[a-z0-9_]+$/', $pag)) {
        $pag = '404';
        $param = [$pag];
        $hasNoTable = 1;
        $scriptPage = '404';
    }

    include('script/index.scr.php');

    $settingFile = "settings/$pag/config.php";
    
    if (!file_exists($settingFile)) $settingFile = "settings_default/$pag/config.php";

    if (file_exists($settingFile)) include($settingFile);

    if (!($hasNoTable ?? false)) {
        // a user may always change his own password (utilizatori-key-id-<own id>)
        $ownKey = ($pag == 'utilizatori') && (($param[1] ?? '') == 'key')
            && isset($_SESSION['userid']) && ((int)($param[3] ?? 0) === (int)$_SESSION['userid']);
        if (!$ownKey && !can_open_page($rcr ?? load_rights(''), $param)) {
            http_response_code(403);
            $scriptPage = '403';
        } else {
            // a list module needs a config file that defines $tabel and $fields
            $configErrors = [];
            if (!file_exists($settingFile)) {
                $configErrors[] = sprintf(t('config_file_not_found'), "<tt>settings/$pag/config.php</tt>");
            } else {
                if (empty($tabel) || !is_string($tabel))
                    $configErrors[] = sprintf(t('config_no_table'), '<tt>$tabel</tt>', "<tt>$settingFile</tt>");
                if (empty($fields) || !is_array($fields))
                    $configErrors[] = sprintf(t('config_no_fields'), '<tt>$fields</tt>', "<tt>$settingFile</tt>");
            }
            if (count($configErrors) > 0) {
                $scriptPage = 'configerror';
            } else {
                $scriptPage = "tabel";
                if (file_exists('script/tabel.scr.php')) {
                    include('script/tabel.scr.php');
                }
            }
        }
    }

    if (!file_exists('template/' . $APP_TEMPLATE . '/' . $scriptPage . '.tpl.php'))
        if (!file_exists($scriptPage))
            $scriptPage = "404";

    include('template/' . $APP_TEMPLATE . '/index.tpl.php');
} else {
    header('Location: ./setup/');
}
?>