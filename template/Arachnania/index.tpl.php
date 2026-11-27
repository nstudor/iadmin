<?php
/**
 * Arachnania — modern sidebar admin layout (Bootstrap 5.3 + Font Awesome 6).
 * Shared markup from fieldtypes / ajax / settings is Bootstrap 4: see css/compat-bs4.css + js/compat-bs4.js.
 */
$T = 'template/' . $APP_TEMPLATE;
$h = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES);
$loggedIn = isset($_SESSION['userid']);
$pageTitle = $title ?? ($loggedIn ? ucfirst((string)$pag) : '');
if (($scriptPage ?? '') == 'dashboard') $pageTitle = t('dashboard');

/** FA icon for a login__menu.icon value (legacy sprite names mapped, other values used as FA names) */
$menuIcon = function ($icon, $hasChildren) {
    $map = ['setari' => 'gear', 'user' => 'user', 'pofile' => 'id-badge', 'profile' => 'id-badge', 'empty' => ''];
    $icon = trim((string)$icon);
    $icon = $map[$icon] ?? $icon;
    if ($icon === '' || !preg_match('/^[a-z0-9-]+$/', $icon)) $icon = $hasChildren ? 'folder' : 'circle-dot';
    return 'fa-solid fa-' . $icon;
};

// menu tree: children by parent id (entries without an id are ignored)
$menuKids = [];
foreach (($menu ?? []) as $m) {
    if (!isset($m['id'], $m['id_tata'])) continue;
    $menuKids[(int)$m['id_tata']][] = $m;
}
$current = (string)($param[0] ?? '');
$isActive = fn($m) => ($m['link'] ?? '') !== '' && ($m['link'] == $current);
$hasActive = function ($id, $depth = 1) use (&$hasActive, $menuKids, $isActive) {
    if ($depth > 3) return false; // the menu has at most 3 levels (also stops on id_tata loops)
    foreach ($menuKids[$id] ?? [] as $c) if ($isActive($c) || $hasActive((int)$c['id'], $depth + 1)) return true;
    return false;
};
/** prints the menu items with parent $parentId (recursive, max 3 levels) */
$renderMenu = function ($parentId, $level) use (&$renderMenu, $menuKids, $isActive, $hasActive, $menuIcon, $h) {
    foreach ($menuKids[$parentId] ?? [] as $m) {
        $id = (int)$m['id'];
        $kids = $level < 3 ? ($menuKids[$id] ?? []) : [];
        if (($m['denum'] ?? '') == '-') {
            echo '<li class="ar-nav-divider"></li>';
            continue;
        }
        if (count($kids) > 0) {
            $open = $hasActive($id);
            echo '<li><a class="ar-nav-link" data-bs-toggle="collapse" href="#arMenu' . $id . '" role="button" aria-expanded="' . ($open ? 'true' : 'false') . '">'
                . '<i class="ar-ico ' . $menuIcon($m['icon'] ?? '', true) . '"></i><span class="ar-label">' . $h($m['denum']) . '</span>'
                . '<i class="ar-caret fa-solid fa-chevron-right"></i></a>'
                . '<ul class="collapse' . ($open ? ' show' : '') . '" id="arMenu' . $id . '">';
            $renderMenu($id, $level + 1);
            echo '</ul></li>';
        } elseif (($m['link'] ?? '') !== '' && $m['link'] != '#') {
            echo '<li><a class="ar-nav-link' . ($isActive($m) ? ' active' : '') . '" href="./' . $h($m['link']) . '.htm">'
                . '<i class="ar-ico ' . $menuIcon($m['icon'] ?? '', false) . '"></i><span class="ar-label">' . $h($m['denum']) . '</span></a></li>';
        }
    }
};
$userName = trim((string)($ruser['nume'] ?? '')) ?: (string)($ruser['user'] ?? '');
$initials = mb_strtoupper(mb_substr($userName, 0, 1)) ?: '?';
?>
<!DOCTYPE html>
<html lang="ro" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $h(trim(($pageTitle ? strip_tags($pageTitle) . ' · ' : '') . $APP_NAME)) ?></title>
    <link rel="icon" type="image/gif" href="favicon.gif" />
    <script>
        // theme before first paint: saved choice, else the OS preference
        (function () {
            var t = null;
            try { t = localStorage.getItem('ar-theme'); } catch (e) {}
            if (!t) t = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-bs-theme', t);
            try { if (localStorage.getItem('ar-sidebar') === 'collapsed') document.documentElement.classList.add('ar-pre-collapsed'); } catch (e) {}
        })();
    </script>
    <meta name="csrf-token" content="<?= $loggedIn ? csrf_token() : '' ?>" />
    <script>window.APP_LNG = <?= json_encode(['loading' => t('loading'), 'error' => t('error'), 'saved' => t('saved'), 'save_failed' => t('save_failed'), 'editing_field' => t('editing_field'), 'close' => t('close')]) ?>;</script>

    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/all.min.css" />
    <link rel="stylesheet" href="./css/v4-shims.min.css" />
    <link rel="stylesheet" href="./css/BsMultiSelect.min.css" />
    <link rel="stylesheet" href="./css/colors.css" />
    <link rel="stylesheet" href="./css/tempus-dominus.css" />
    <link rel="stylesheet" href="./css/bootstrap-colorpicker.min.css" />
    <link rel="stylesheet" href="./css/compat-bs4.css" />
    <link rel="stylesheet" href="./<?= $T ?>/arachnania.css" />

    <script src="./js/jquery.min.js"></script>
    <script src="./js/csrf.js"></script>
    <script src="./js/fieldtypes.js"></script>
    <script src="./js/compat-bs4.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/tempus-dominus.js"></script>
    <script src="./js/jQuery-provider.js"></script>
    <script src="./js/ckeditor/ckeditor.js"></script>
    <script src="./js/bootstrap-colorpicker.js"></script>
    <script src="./js/BsMultiSelect.min.js"></script>
    <script src="./<?= $T ?>/arachnania.js"></script>
    <?php
    if (file_exists("$T/$scriptPage.head.php")) include("$T/$scriptPage.head.php");
    ?>
</head>

<body data-pag="<?= $h($pag ?? '') ?>">
    <script>if (document.documentElement.classList.contains('ar-pre-collapsed')) document.body.classList.add('ar-collapsed');</script>

    <?php if ($loggedIn) { ?>
        <div class="ar-shell">
            <aside class="ar-sidebar" aria-label="<?= t('menu') ?>">
                <a class="ar-brand" href="./">
                    <span class="ar-brand-icon"><i class="fa-solid fa-spider"></i></span>
                    <span class="ar-brand-text"><?= $h($APP_NAME) ?></span>
                </a>
                <nav class="ar-nav">
                    <ul>
                        <li><a class="ar-nav-link<?= ($scriptPage ?? '') == 'dashboard' ? ' active' : '' ?>" href="./"><i class="ar-ico fa-solid fa-house"></i><span class="ar-label"><?= t('dashboard') ?></span></a></li>
                        <li class="ar-nav-section"><?= t('menu') ?></li>
                        <?php $renderMenu(0, 1); ?>
                    </ul>
                </nav>
            </aside>
            <div class="ar-backdrop"></div>

            <div class="ar-main">
                <header class="ar-topbar">
                    <button class="ar-icon-btn" type="button" data-ar-sidebar-toggle aria-label="<?= t('toggle_navigation') ?>"><i class="fa-solid fa-bars"></i></button>
                    <h1 class="ar-title"><?= $pageTitle ?></h1>
                    <span class="ar-clock d-none d-md-inline" id="clock">&nbsp;</span>
                    <button class="ar-icon-btn" type="button" data-ar-theme-toggle aria-label="<?= t('light_dark') ?>"><i class="fa-solid fa-moon"></i></button>
                    <div class="dropdown">
                        <button class="ar-icon-btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="<?= t('account') ?>">
                            <span class="ar-avatar"><?= $h($initials) ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header"><?= $h($userName) ?></li>
                            <li><a class="dropdown-item" href="./utilizatori-key-id-<?= (int)$_SESSION['userid'] ?>.htm"><i class="fa-solid fa-key me-2"></i><?= t('change_password') ?></a></li>
                            <?php if (($ruser['role'] ?? 0) == 1) { ?>
                                <li><a class="dropdown-item" href="./loginmenu.htm"><i class="fa-solid fa-sitemap me-2"></i><?= t('developer_menu') ?></a></li>
                            <?php } ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="./logout.htm"><i class="fa-solid fa-right-from-bracket me-2"></i><?= t('logout') ?></a></li>
                        </ul>
                    </div>
                </header>

                <main class="ar-content" id="arContent">
                    <?php
                    if (file_exists("$T/$scriptPage.tpl.php")) include("$T/$scriptPage.tpl.php");
                    elseif (file_exists($scriptPage)) include($scriptPage);
                    ?>
                </main>
            </div>
        </div>

        <!-- shared modal used by goModal() / postModal() and data-toggle="modal" data-target="#filterModal" -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-gray text-white">
                        <h5 class="modal-title" id="filterModalTitle">&nbsp;</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <!-- inline cell editor (right click on a list cell) -->
        <div id="contextMenu" class="card" style="display:none">
            <div class="card-header d-flex align-items-center bg-gray text-white">
                <span class="panel-info me-auto"></span>
                <i class="fa-solid fa-xmark" data-ar-close style="cursor:pointer"></i>
            </div>
            <div class="card-body">
                <div class="panel-data"></div>
                <div class="panel-submit d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-primary flex-fill" onclick="salveaza()"><?= t('ok') ?></button>
                    <button type="button" class="btn btn-outline-secondary flex-fill" data-ar-close><?= t('cancel') ?></button>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="ar-auth">
            <button class="ar-icon-btn ar-auth-theme" type="button" data-ar-theme-toggle aria-label="<?= t('light_dark') ?>"><i class="fa-solid fa-moon"></i></button>
            <div class="ar-auth-inner" id="arContent">
                <div class="ar-auth-brand">
                    <span class="ar-brand-icon"><i class="fa-solid fa-spider"></i></span>
                    <span><?= $h($APP_NAME) ?></span>
                </div>
                <div class="card ar-auth-card">
                    <?php
                    if (file_exists("$T/$scriptPage.tpl.php")) include("$T/$scriptPage.tpl.php");
                    elseif (file_exists($scriptPage)) include($scriptPage);
                    ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="ar-toasts" id="arToasts" aria-live="polite"></div>
</body>

</html>
