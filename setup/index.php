<?php
/**
 * iAdmin setup: runs only while settings.ini does not exist (index.php redirects here).
 * 1. validates the form   2. connects to the database   3. imports setup/schema.<language>.sql
 * 4. writes ../settings.ini (only after the database is ready)
 */
error_reporting(0);

$root = dirname(__DIR__);
$settingsFile = "$root/settings.ini";
$schemaFile = __DIR__ . '/schema.english.sql'; // tables + seed data, one file per language: schema.<APP_LANGUAGE>.sql
$h = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES);

// choices offered by the form (also the only accepted values)
$templates = array_values(array_filter(scandir("$root/template"), fn($d) => $d[0] != '.' && is_dir("$root/template/$d")));
$languages = array_map(fn($f) => basename($f, '.lng.php'), glob("$root/lang/*.lng.php"));
$connectors = array_map(fn($f) => basename($f, '.con.php'), glob("$root/connector/*.con.php"));

$installed = file_exists($settingsFile);
$s = [
    'APP_NAME' => 'iAdmin',
    'APP_TEMPLATE' => in_array('Badmannahy', $templates) ? 'Badmannahy' : ($templates[0] ?? ''),
    'APP_LANGUAGE' => in_array('english', $languages) ? 'english' : ($languages[0] ?? ''),
    'APP_DB_TYPE' => in_array('mySQL', $connectors) ? 'mySQL' : ($connectors[0] ?? ''),
    'APP_DB_SERVER' => 'localhost',
    'APP_DB_NAME' => '',
    'APP_DB_USER' => '',
    'APP_DB_PASS' => '',
    'APP_DB_PORT' => '3306',
];
$admin = ['user' => 'admin', 'name' => '', 'email' => ''];
$replace = false;
$errors = [];      // field => message
$errorStep = 1;
$done = false;
$settingsText = '';

if (!$installed && $_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($s as $k => $v) $s[$k] = trim((string)($_POST['s'][$k] ?? ''));
    $s['APP_DB_PASS'] = (string)($_POST['s']['APP_DB_PASS'] ?? ''); // keep spaces in passwords
    $admin = [
        'user' => trim((string)($_POST['iUser'] ?? '')),
        'name' => trim((string)($_POST['iName'] ?? '')),
        'email' => trim((string)($_POST['iEmail'] ?? '')),
    ];
    $pass = (string)($_POST['iPass'] ?? '');
    $pass2 = (string)($_POST['iPass2'] ?? '');
    $replace = !empty($_POST['replace']);

    // ---- step 1
    if ($s['APP_NAME'] === '' || mb_strlen($s['APP_NAME']) > 100) $errors['APP_NAME'] = 'Enter an application name (max 100 characters).';
    if (!in_array($s['APP_TEMPLATE'], $templates, true)) $errors['APP_TEMPLATE'] = 'Choose a template.';
    if (!in_array($s['APP_LANGUAGE'], $languages, true)) $errors['APP_LANGUAGE'] = 'Choose a language.';
    // seed data (menu names, dashboard panels, public pages) in the chosen language; English when there is no file for it
    elseif (is_file(__DIR__ . "/schema.{$s['APP_LANGUAGE']}.sql")) $schemaFile = __DIR__ . "/schema.{$s['APP_LANGUAGE']}.sql";
    // ---- step 2
    if (!in_array($s['APP_DB_TYPE'], $connectors, true)) $errors['APP_DB_TYPE'] = 'Choose a database type.';
    if ($s['APP_DB_SERVER'] === '') $errors['APP_DB_SERVER'] = 'Enter the database server.';
    if ($s['APP_DB_NAME'] === '') $errors['APP_DB_NAME'] = 'Enter the database name.';
    if ($s['APP_DB_USER'] === '') $errors['APP_DB_USER'] = 'Enter the database user.';
    if (!ctype_digit($s['APP_DB_PORT']) || (int)$s['APP_DB_PORT'] < 1 || (int)$s['APP_DB_PORT'] > 65535) $errors['APP_DB_PORT'] = 'Enter a port between 1 and 65535.';
    // ---- step 3
    if (!preg_match('/^[A-Za-z0-9._@-]{3,32}$/', $admin['user'])) $errors['iUser'] = '3-32 characters: letters, digits and . _ @ -';
    if (mb_strlen($admin['name']) > 200) $errors['iName'] = 'Max 200 characters.';
    if ($admin['email'] !== '' && !filter_var($admin['email'], FILTER_VALIDATE_EMAIL)) $errors['iEmail'] = 'Enter a valid e-mail address (or leave it empty).';
    if (strlen($pass) < 6) $errors['iPass'] = 'The password must have at least 6 characters.';
    elseif ($pass !== $pass2) $errors['iPass2'] = 'The passwords do not match.';
    if (!is_file($schemaFile)) $errors['_'] = 'setup/' . basename($schemaFile) . ' is missing.';
    if (!is_writable($root)) $errors['_'] = 'The application folder is not writable, settings.ini cannot be created. Allow the web server to write to it and try again.';

    if (!$errors) {
        // ---- database: connect, check for existing tables, import the schema
        foreach ($s as $k => $v) $$k = $v; // $APP_DB_SERVER, $APP_DB_USER ... used by db_connect()
        include_once("$root/utils.php"); // t() for the connector messages
        include("$root/lang/english.lng.php");
        $_DEFLNG = $_LNG;
        include("$root/connector/$APP_DB_TYPE.con.php");
        if (!db_connect()) {
            $errors['APP_DB_SERVER'] = 'Cannot connect to the database: ' . $MESSAGE;
        } else {
            $existing = array_values(array_intersect(db_schema_tables($schemaFile), db_tables()));
            if ($existing && !$replace) {
                $errors['replace'] = 'The database already contains iAdmin tables (' . implode(', ', $existing) .
                    '). Tick "Replace existing tables" to delete and recreate them, or use another database.';
            } elseif (!db_initialize($schemaFile, [
                'USER' => $admin['user'],
                'PASS' => password_hash($pass, PASSWORD_DEFAULT),
                'NAME' => $admin['name'] !== '' ? $admin['name'] : $admin['user'],
                'EMAIL' => $admin['email'],
            ], $replace)) {
                $errors['_'] = 'Importing the database schema failed: ' . $MESSAGE;
            }
        }
    }

    if (!$errors) {
        // ---- settings.ini (PHP file, values exported safely)
        $settingsText = "<?php\r\n";
        foreach ($s as $k => $v) $settingsText .= '$' . $k . ' = ' . var_export($v, true) . ";\r\n";
        $settingsText .= "\$DEBUG_MODE = false;\r\n";
        $done = file_put_contents($settingsFile, $settingsText, LOCK_EX) !== false;
        if (!$done) $errors['_'] = 'The database is ready, but settings.ini could not be written.';
    }

    if ($errors) {
        $step2 = ['APP_DB_TYPE', 'APP_DB_SERVER', 'APP_DB_NAME', 'APP_DB_USER', 'APP_DB_PORT'];
        $step3 = ['iUser', 'iName', 'iEmail', 'iPass', 'iPass2', 'replace', '_'];
        $first = array_key_first($errors);
        $errorStep = in_array($first, $step2) ? 2 : (in_array($first, $step3) ? 3 : 1);
    }
}

$invalid = fn($k) => isset($errors[$k]) ? ' is-invalid' : '';
$feedback = fn($k) => isset($errors[$k]) ? '<div class="invalid-feedback">' . $h($errors[$k]) . '</div>' : '';
$options = function ($list, $selected, $label = null) use ($h) {
    foreach ($list as $v) echo '<option value="' . $h($v) . '"' . ($v === $selected ? ' selected' : '') . '>' . $h($label ? $label($v) : $v) . '</option>';
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>iAdmin - Setup</title>
    <link rel="icon" type="image/gif" href="favicon.gif" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/all.min.css" />
    <script src="../js/bootstrap.bundle.min.js"></script>
    <style>
        body { background: #f3f4f8; }
        .setup { max-width: 640px; margin: 6vh auto; }
        .step { display: none; }
        .step.active { display: block; }
        .steps .badge { font-size: .8rem; }
    </style>
</head>

<body>
    <div class="container setup">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2">
                <img src="favicon.gif" height="28" alt="" />
                <strong><span class="text-primary">i</span>Admin</strong> &middot; Setup
                <?php if (!$installed && !$done) { ?>
                    <span class="ms-auto steps">
                        <span class="badge rounded-pill text-bg-secondary" data-step-badge="1">1 Application</span>
                        <span class="badge rounded-pill text-bg-secondary" data-step-badge="2">2 Database</span>
                        <span class="badge rounded-pill text-bg-secondary" data-step-badge="3">3 Administrator</span>
                    </span>
                <?php } ?>
            </div>

            <?php if ($installed) { ?>
                <div class="card-body">
                    <div class="alert alert-info mb-3"><i class="fa-solid fa-circle-info me-2"></i>iAdmin is already installed (<code>settings.ini</code> exists).</div>
                    <p class="text-body-secondary small">To run the setup again, delete <code>settings.ini</code> from the application folder first.</p>
                    <a href="../" class="btn btn-primary float-end">Open the application &raquo;</a>
                </div>

            <?php } elseif ($done) { ?>
                <div class="card-body">
                    <div class="alert alert-success mb-3"><i class="fa-solid fa-circle-check me-2"></i>Setup completed! <code>settings.ini</code> was created and the database is ready.</div>
                    <p>Sign in as <strong><?= $h($admin['user']) ?></strong> with the password you chose.</p>
                    <a href="../" class="btn btn-primary float-end">Go to sign in &raquo;</a>
                </div>

            <?php } else { ?>
                <form method="post" action="" novalidate>
                    <?php if (isset($errors['_'])) { ?>
                        <div class="alert alert-danger m-3 mb-0"><i class="fa-solid fa-triangle-exclamation me-2"></i><?= $h($errors['_']) ?>
                            <?php if ($settingsText !== '' && !$done) { ?>
                                <div class="mt-2 small">Create <code>settings.ini</code> in the application folder with this content:</div>
                                <textarea class="form-control font-monospace small mt-1" rows="12" readonly><?= $h($settingsText) ?></textarea>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <!-- step 1: application -->
                    <div class="card-body step" data-step="1">
                        <div class="mb-3">
                            <label class="form-label" for="appName">Application name</label>
                            <input name="s[APP_NAME]" type="text" class="form-control<?= $invalid('APP_NAME') ?>" id="appName" placeholder="Ex. iAdmin example program" value="<?= $h($s['APP_NAME']) ?>" />
                            <?= $feedback('APP_NAME') ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tmpName">Template</label>
                            <select name="s[APP_TEMPLATE]" class="form-select<?= $invalid('APP_TEMPLATE') ?>" id="tmpName"><?php $options($templates, $s['APP_TEMPLATE']) ?></select>
                            <?= $feedback('APP_TEMPLATE') ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lngName">Language</label>
                            <select name="s[APP_LANGUAGE]" class="form-select<?= $invalid('APP_LANGUAGE') ?>" id="lngName"><?php $options($languages, $s['APP_LANGUAGE'], 'ucfirst') ?></select>
                            <?= $feedback('APP_LANGUAGE') ?>
                        </div>
                        <button type="button" class="btn btn-primary float-end" data-go="2">Next &raquo;</button>
                    </div>

                    <!-- step 2: database -->
                    <div class="card-body step" data-step="2">
                        <div class="mb-3">
                            <label class="form-label" for="dbType">Database type</label>
                            <select name="s[APP_DB_TYPE]" class="form-select<?= $invalid('APP_DB_TYPE') ?>" id="dbType"><?php $options($connectors, $s['APP_DB_TYPE']) ?></select>
                            <?= $feedback('APP_DB_TYPE') ?>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-8">
                                <label class="form-label" for="dbServer">Database server</label>
                                <input name="s[APP_DB_SERVER]" type="text" class="form-control<?= $invalid('APP_DB_SERVER') ?>" id="dbServer" value="<?= $h($s['APP_DB_SERVER']) ?>" />
                                <?= $feedback('APP_DB_SERVER') ?>
                            </div>
                            <div class="col-4">
                                <label class="form-label" for="dbPort">Port</label>
                                <input name="s[APP_DB_PORT]" type="text" inputmode="numeric" class="form-control<?= $invalid('APP_DB_PORT') ?>" id="dbPort" value="<?= $h($s['APP_DB_PORT']) ?>" />
                                <?= $feedback('APP_DB_PORT') ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="dbName">Database name <span class="text-body-secondary small">(must exist)</span></label>
                            <input name="s[APP_DB_NAME]" type="text" class="form-control<?= $invalid('APP_DB_NAME') ?>" id="dbName" placeholder="Ex. iadmin_db" value="<?= $h($s['APP_DB_NAME']) ?>" />
                            <?= $feedback('APP_DB_NAME') ?>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="dbUser">Database user</label>
                                <input name="s[APP_DB_USER]" type="text" class="form-control<?= $invalid('APP_DB_USER') ?>" id="dbUser" autocomplete="off" value="<?= $h($s['APP_DB_USER']) ?>" />
                                <?= $feedback('APP_DB_USER') ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="dbPass">Database password</label>
                                <input name="s[APP_DB_PASS]" type="password" class="form-control" id="dbPass" autocomplete="new-password" value="<?= $h($s['APP_DB_PASS']) ?>" />
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" data-go="1">&laquo; Prev</button>
                        <button type="button" class="btn btn-primary float-end" data-go="3">Next &raquo;</button>
                    </div>

                    <!-- step 3: administrator -->
                    <div class="card-body step" data-step="3">
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="iUser">Admin user name</label>
                                <input name="iUser" type="text" class="form-control<?= $invalid('iUser') ?>" id="iUser" autocomplete="off" value="<?= $h($admin['user']) ?>" />
                                <?= $feedback('iUser') ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="iName">Full name <span class="text-body-secondary small">(optional)</span></label>
                                <input name="iName" type="text" class="form-control<?= $invalid('iName') ?>" id="iName" value="<?= $h($admin['name']) ?>" />
                                <?= $feedback('iName') ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="iEmail">E-mail <span class="text-body-secondary small">(for password recovery)</span></label>
                            <input name="iEmail" type="email" class="form-control<?= $invalid('iEmail') ?>" id="iEmail" value="<?= $h($admin['email']) ?>" />
                            <?= $feedback('iEmail') ?>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="iPass">Password</label>
                                <input name="iPass" type="password" class="form-control<?= $invalid('iPass') ?>" id="iPass" autocomplete="new-password" />
                                <?= $feedback('iPass') ?>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="iPass2">Repeat password</label>
                                <input name="iPass2" type="password" class="form-control<?= $invalid('iPass2') ?>" id="iPass2" autocomplete="new-password" />
                                <?= $feedback('iPass2') ?>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input<?= $invalid('replace') ?>" type="checkbox" name="replace" value="1" id="replace" <?= $replace ? 'checked' : '' ?> />
                            <label class="form-check-label" for="replace">Replace existing iAdmin tables <span class="text-danger small">(deletes their data)</span></label>
                            <?= $feedback('replace') ?>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" data-go="2">&laquo; Prev</button>
                        <button class="btn btn-success float-end" type="submit"><i class="fa-solid fa-check me-1"></i> Install</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
    <script>
        function showStep(n) {
            document.querySelectorAll('.step').forEach(function (el) { el.classList.toggle('active', el.dataset.step == n); });
            document.querySelectorAll('[data-step-badge]').forEach(function (el) {
                el.className = 'badge rounded-pill ' + (el.dataset.stepBadge == n ? 'text-bg-primary' : 'text-bg-secondary');
            });
        }
        document.querySelectorAll('[data-go]').forEach(function (b) {
            b.addEventListener('click', function () { showStep(b.dataset.go); });
        });
        showStep(<?= (int)$errorStep ?>);
    </script>
</body>

</html>
