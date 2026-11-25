<?php
function showMessage($msg, $type = 'success', $print = 0, $icon = 1)
{
    if ($icon) {
        // TODO: SHOW ICON STUFF
    }
    $txt = '<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';
    if ($print) {
        echo $txt;
    }
    return $txt;
}
function pr($x)
{
    echo "<pre>";
    print_r($x);
    echo "</pre>";
}
function sendMail($mailArray) {
    mail($mailArray['to'], $mailArray['subject'], $mailArray['message']);
}
function fieldFormat($fieldId, $fieldDef, $fieldValue, $operation = '', $pre = '', $rowId = 0, $uri = '')
{
    $type = (empty($fieldDef['type']) ? 'text' : $fieldDef['type']);
    if (!empty($operation)) {
        $operation = "_$operation";
        if (empty($pre)) {
            $pre = '../';
        }
    }
    if (file_exists("{$pre}fieldtypes/$type$operation.type.php")) {
        include("{$pre}fieldtypes/$type$operation.type.php");
    } else {
        include("{$pre}ajax/404.php");
    }
}
function t($x) {
    global $_LNG, $_DEFLNG;
    return (isset($_LNG[$x])?$_LNG[$x]:(isset($_DEFLNG[$x])?$_DEFLNG[$x]:"%%$x%%"));
}

/* ---------- Field types ---------- */

/**
 * Resolves an awesomecase field definition: applies its preset ('template', see fieldtypes/awesomecase/)
 * and returns the definition with array 'values' plus per-value maps
 * t (icon), c (color), s (class) and f (Font Awesome type).
 */
function awesomecase_def($fieldDef)
{
    $fieldDef = is_array($fieldDef) ? $fieldDef : [];
    $tpl = (string)($fieldDef['template'] ?? '');
    if ($tpl !== '' && preg_match('/^[A-Za-z0-9_]+$/', $tpl) && file_exists(__DIR__ . "/fieldtypes/awesomecase/$tpl.tpl.type.php"))
        include __DIR__ . "/fieldtypes/awesomecase/$tpl.tpl.type.php";
    foreach (['values', 'chars', 'colors', 'classes', 'fatype'] as $key)
        if (!is_array($fieldDef[$key] ?? null)) $fieldDef[$key] = explode(',', (string)($fieldDef[$key] ?? ''));
    foreach ($fieldDef['values'] as $i => $v) {
        $fieldDef['t'][$v] = $fieldDef['chars'][$i] ?? '';
        $fieldDef['c'][$v] = $fieldDef['colors'][$i] ?? '';
        $fieldDef['s'][$v] = $fieldDef['classes'][$i] ?? '';
        $fieldDef['f'][$v] = $fieldDef['fatype'][$i] ?? '';
    }
    return $fieldDef;
}

/* ---------- Dates ---------- */

/**
 * Replacement for strftime() (deprecated since PHP 8.1), same % format codes.
 * Day / month names use the current setlocale(LC_TIME) locale through IntlDateFormatter
 * when the intl extension is available, otherwise English names from date().
 */
function format_strftime($format, $timestamp = null, $locale = null)
{
    $timestamp = $timestamp === null ? time() : (int)$timestamp;
    if ($locale === null) {
        $locale = setlocale(LC_TIME, 0);
        if (!$locale || $locale == 'C' || $locale == 'POSIX') $locale = 'en_US';
    }
    $locale = preg_replace('/[.@].*$/', '', $locale); // ro_RO.utf8 -> ro_RO

    // codes whose text depends on the locale => ICU pattern
    $intl = ['a' => 'EEE', 'A' => 'EEEE', 'b' => 'MMM', 'h' => 'MMM', 'B' => 'MMMM', 'p' => 'a'];
    // everything else => date() format (or a callback)
    $plain = [
        'a' => 'D', 'A' => 'l', 'b' => 'M', 'h' => 'M', 'B' => 'F', 'p' => 'A', 'P' => 'a',
        'd' => 'd', 'e' => 'j', 'u' => 'N', 'w' => 'w', 'V' => 'W', 'G' => 'o',
        'm' => 'm', 'y' => 'y', 'Y' => 'Y', 'C' => fn($t) => sprintf('%02d', intdiv((int)date('Y', $t), 100)),
        'j' => fn($t) => sprintf('%03d', (int)date('z', $t) + 1),
        'H' => 'H', 'k' => fn($t) => sprintf('%2d', (int)date('G', $t)), 'I' => 'h', 'l' => fn($t) => sprintf('%2d', (int)date('g', $t)),
        'M' => 'i', 'S' => 's', 's' => 'U', 'z' => 'O', 'Z' => 'T',
        'D' => 'm/d/y', 'F' => 'Y-m-d', 'T' => 'H:i:s', 'R' => 'H:i', 'r' => 'h:i:s A',
        'n' => fn($t) => "\n", 't' => fn($t) => "\t", '%' => fn($t) => '%',
    ];
    $useIntl = class_exists('IntlDateFormatter');

    return preg_replace_callback('/%([a-zA-Z%])/', function ($m) use ($timestamp, $locale, $intl, $plain, $useIntl) {
        $c = $m[1];
        if ($useIntl && isset($intl[$c])) {
            $fmt = new IntlDateFormatter($locale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, $intl[$c]);
            return $fmt->format($timestamp);
        }
        if (!isset($plain[$c])) return $m[0];
        return $plain[$c] instanceof Closure ? $plain[$c]($timestamp) : date($plain[$c], $timestamp);
    }, (string)$format);
}

/* ---------- Rights ---------- */

/**
 * Loads the rights of the logged-in user for module $pag, always from the DB.
 * No login__menu row (link = $pag) or no login__rights row means no rights.
 * A menu row with right='Y' (visible to everyone) grants view_right.
 */
function load_rights($pag)
{
    $rights = [
        'view_right' => 'N',
        'add_right' => 'N',
        'modify_right' => 'N',
        'delete_right' => 'N',
    ];
    $user = empty($_SESSION['userid']) ? null : (db_select('role', 'login__users', 'id=' . (int)$_SESSION['userid'])[0] ?? null);
    $menu = $user ? (db_select('*', 'login__menu', "link='" . db_esc($pag) . "'")[0] ?? null) : null;
    $row = $menu ? (db_select('*', 'login__rights', 'id_menu=' . (int)$menu['id'] . ' AND id_role=' . (int)$user['role'])[0] ?? []) : [];

    $rights = array_merge($row, $rights, array_intersect_key($row, $rights));
    if (($menu['right'] ?? '') == 'Y') $rights['view_right'] = 'Y';
    foreach (['v', 'a', 'm', 'd'] as $t) {
        $rights["details_$t"] = array_values(array_filter(explode(' ', $row["details_$t"] ?? '')));
    }
    return $rights;
}

/** True if $rights (from load_rights) has $right = 'Y' (view_right, add_right, modify_right, delete_right) */
function has_right($rights, $right)
{
    return ($rights[$right] ?? 'N') == 'Y';
}

/**
 * Can the page described by $param (module-command-key-value...) be opened with $rights?
 * list -> view, add -> add, edit -> modify, drop -> delete,
 * any other command is a special: view_right + listed in details_v (details_m for POST).
 */
function can_open_page($rights, $param)
{
    $cmd = (isset($param[1]) && !is_numeric($param[1])) ? $param[1] : '';
    switch ($cmd) {
        case '':
            return has_right($rights, 'view_right');
        case 'add':
            return has_right($rights, 'add_right');
        case 'edit':
            return has_right($rights, 'modify_right');
        case 'drop':
            return has_right($rights, 'delete_right');
        default:
            if (!has_right($rights, 'view_right') || !in_array($cmd, $rights['details_v'])) return false;
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !in_array($cmd, $rights['details_m'])) return false;
            return true;
    }
}

/**
 * Special pages of module $mod: [$specials, $stitles] from its config
 * (settings/<mod>/config.php, else settings_default/<mod>/config.php).
 * $pre is the path to the app root ('' from index.php, '../' from ajax/).
 */
function module_specials($mod, $pre = '')
{
    if (!preg_match('/^[a-z0-9_]+$/', (string)$mod)) return [[], []];
    $file = "{$pre}settings/$mod/config.php";
    if (!file_exists($file)) $file = "{$pre}settings_default/$mod/config.php";
    if (!file_exists($file)) return [[], []];
    // include in its own scope so the module's variables don't leak into the caller
    return (function () use ($file) {
        $specials = [];
        $stitles = [];
        include $file;
        return [(array)$specials, (array)$stitles];
    })();
}

/* ---------- CSRF ---------- */

/** The CSRF token of the current session */
function csrf_token()
{
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

/** True if the request carries the session CSRF token (POST field _csrf or header X-CSRF-Token) */
function csrf_ok()
{
    $sent = $_POST['_csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    return !empty($_SESSION['csrf']) && is_string($sent) && hash_equals($_SESSION['csrf'], $sent);
}

/* ---------- Passwords ---------- */

/** Checks a password against the stored password_hash() value */
function password_check($plain, $stored)
{
    $stored = (string)$stored;
    if ($stored === '') return false;
    return password_verify((string)$plain, $stored);
}

/**
 * Saves a new password for user $userId with password_hash().
 * Returns false (and sets $MESSAGE) when the hash could not be stored completely
 * (login__users.pass must be varchar(255)).
 */
function password_store($userId, $plain)
{
    global $MESSAGE;
    $userId = (int)$userId;
    $hash = password_hash((string)$plain, PASSWORD_DEFAULT);
    if (!db_update(['pass' => $hash], 'login__users', "id=$userId")) return false;
    $saved = db_select('pass', 'login__users', "id=$userId")[0]['pass'] ?? '';
    if ($saved !== $hash) {
        $MESSAGE = 'The password could not be saved: the login__users.pass column must be varchar(255).';
        return false;
    }
    return true;
}
?>
