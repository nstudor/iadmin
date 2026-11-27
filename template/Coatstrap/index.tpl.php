<?php
/**
 * Coatstrap — sidebar admin layout built ONLY from Bootstrap 5.3 classes (no template stylesheet, no <style>).
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
/** nav-link classes: active pill, otherwise body colored link */
$linkClass = fn($active) => 'nav-link d-flex align-items-center gap-2 ' . ($active ? 'active' : 'link-body-emphasis');
/** prints the menu items with parent $parentId (recursive, max 3 levels) */
$renderMenu = function ($parentId, $level) use (&$renderMenu, $menuKids, $isActive, $hasActive, $menuIcon, $linkClass, $h) {
    foreach ($menuKids[$parentId] ?? [] as $m) {
        $id = (int)$m['id'];
        $kids = $level < 3 ? ($menuKids[$id] ?? []) : [];
        if (($m['denum'] ?? '') == '-') {
            echo '<li class="nav-item"><hr class="my-2"></li>';
            continue;
        }
        if (count($kids) > 0) {
            $open = $hasActive($id);
            echo '<li class="nav-item"><a class="' . $linkClass(false) . '" data-bs-toggle="collapse" href="#csMenu' . $id . '" role="button" aria-expanded="' . ($open ? 'true' : 'false') . '" aria-controls="csMenu' . $id . '">'
                . '<i class="' . $menuIcon($m['icon'] ?? '', true) . ' fa-fw opacity-75"></i><span class="text-truncate">' . $h($m['denum']) . '</span>'
                . '<i class="fa-solid fa-chevron-' . ($open ? 'down' : 'right') . ' ms-auto small opacity-50" data-cs-caret></i></a>'
                . '<ul class="collapse' . ($open ? ' show' : '') . ' nav nav-pills flex-column gap-1 small ms-3 ps-2 my-1 border-start" id="csMenu' . $id . '">';
            $renderMenu($id, $level + 1);
            echo '</ul></li>';
        } elseif (($m['link'] ?? '') !== '' && $m['link'] != '#') {
            echo '<li class="nav-item"><a class="' . $linkClass($isActive($m)) . '" href="./' . $h($m['link']) . '.htm"' . ($isActive($m) ? ' aria-current="page"' : '') . '>'
                . '<i class="' . $menuIcon($m['icon'] ?? '', false) . ' fa-fw opacity-75"></i><span class="text-truncate">' . $h($m['denum']) . '</span></a></li>';
        }
    }
};
$userName = trim((string)($ruser['nume'] ?? '')) ?: (string)($ruser['user'] ?? '');
$isDash = ($scriptPage ?? '') == 'dashboard';
// public pages: narrow card for the small forms, wide card for the login__pages content
$authCol = in_array($scriptPage ?? '', ['recover', 'logout']) ? 'col-sm-10 col-md-7 col-lg-5 col-xl-4' : 'col-lg-10 col-xl-9';
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
            try { t = localStorage.getItem('cs-theme'); } catch (e) {}
            if (!t) t = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-bs-theme', t);
        })();
    </script>
    <meta name="csrf-token" content="<?= $loggedIn ? csrf_token() : '' ?>" />
    <script>window.APP_LNG = <?= json_encode(['loading' => t('loading'), 'error' => t('error'), 'saved' => t('saved'), 'save_failed' => t('save_failed'), 'editing_field' => t('editing_field'), 'close' => t('close')]) ?>;</script>

    <!-- Bootstrap is the only design layer; the rest are the widget / compatibility styles shared code needs -->
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/all.min.css" />
    <link rel="stylesheet" href="./css/v4-shims.min.css" />
    <link rel="stylesheet" href="./css/BsMultiSelect.min.css" />
    <link rel="stylesheet" href="./css/tempus-dominus.css" />
    <link rel="stylesheet" href="./css/bootstrap-colorpicker.min.css" />
    <link rel="stylesheet" href="./css/compat-bs4.css" />
    <!-- colors.css only for custom pages (settings/*, fieldtype configs): Coatstrap's own markup does not use it -->
    <link rel="stylesheet" href="./css/colors.css" />

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
    <script src="./<?= $T ?>/coatstrap.js"></script>
    <?php
    if (file_exists("$T/$scriptPage.head.php")) include("$T/$scriptPage.head.php");
    ?>
</head>

<body data-pag="<?= $h($pag ?? '') ?>">

    <?php if ($loggedIn) { ?>
        <div class="container-fluid p-0">
            <div class="row g-0 min-vh-100 align-content-start">

                <!-- sidebar: in the page on >= lg, off-canvas below -->
                <div class="col-lg-3 col-xl-2 bg-body-tertiary border-end">
                    <aside class="offcanvas-lg offcanvas-start sticky-lg-top vh-100 overflow-y-auto" tabindex="-1" id="csSidebar" aria-labelledby="csSidebarLabel">
                        <div class="offcanvas-header border-bottom">
                            <span class="offcanvas-title fs-5 fw-semibold" id="csSidebarLabel"><?= $h($APP_NAME) ?></span>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#csSidebar" aria-label="<?= t('close') ?>"></button>
                        </div>
                        <div class="offcanvas-body d-flex flex-column">
                            <a class="d-none d-lg-flex align-items-center gap-2 px-3 py-3 border-bottom fs-5 fw-semibold link-body-emphasis text-decoration-none" href="./">
                                <span class="badge text-bg-primary p-2 fs-6"><i class="fa-solid fa-shirt fa-fw"></i></span>
                                <span class="text-truncate"><?= $h($APP_NAME) ?></span>
                            </a>
                            <nav class="p-2 pb-4" aria-label="<?= t('menu') ?>">
                                <ul class="nav nav-pills flex-column gap-1">
                                    <li class="nav-item"><a class="<?= $linkClass($isDash) ?>" href="./"<?= $isDash ? ' aria-current="page"' : '' ?>><i class="fa-solid fa-house fa-fw opacity-75"></i><span><?= t('dashboard') ?></span></a></li>
                                    <li class="nav-item small text-body-secondary text-uppercase fw-semibold px-3 pt-3 pb-1"><?= t('menu') ?></li>
                                    <?php $renderMenu(0, 1); ?>
                                </ul>
                            </nav>
                        </div>
                    </aside>
                </div>

                <div class="col-lg-9 col-xl-10 d-flex flex-column">
                    <header class="navbar sticky-top bg-body border-bottom shadow-sm px-3 gap-2 flex-nowrap">
                        <button class="btn btn-link link-body-emphasis d-lg-none px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#csSidebar" aria-controls="csSidebar" aria-label="<?= t('menu') ?>"><i class="fa-solid fa-bars"></i></button>
                        <h1 class="h5 mb-0 me-auto text-truncate"><?= $pageTitle ?></h1>
                        <span class="small text-body-secondary text-nowrap d-none d-md-inline" id="clock">&nbsp;</span>
                        <button class="btn btn-link link-body-emphasis px-2" type="button" data-cs-theme-toggle aria-label="<?= t('light_dark') ?>"><i class="fa-solid fa-moon"></i></button>
                        <div class="dropdown">
                            <button class="btn btn-link link-body-emphasis px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="<?= t('account') ?>">
                                <i class="fa-solid fa-circle-user fs-4 align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><h6 class="dropdown-header"><?= $h($userName) ?></h6></li>
                                <li><a class="dropdown-item" href="./utilizatori-key-id-<?= (int)$_SESSION['userid'] ?>.htm"><i class="fa-solid fa-key fa-fw me-2"></i><?= t('change_password') ?></a></li>
                                <?php if (($ruser['role'] ?? 0) == 1) { ?>
                                    <li><a class="dropdown-item" href="./loginmenu.htm"><i class="fa-solid fa-sitemap fa-fw me-2"></i><?= t('developer_menu') ?></a></li>
                                <?php } ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="./logout.htm"><i class="fa-solid fa-right-from-bracket fa-fw me-2"></i><?= t('logout') ?></a></li>
                            </ul>
                        </div>
                    </header>

                    <main class="flex-grow-1 p-3 p-lg-4" id="csContent">
                        <?php
                        if (file_exists("$T/$scriptPage.tpl.php")) include("$T/$scriptPage.tpl.php");
                        elseif (file_exists($scriptPage)) include($scriptPage);
                        ?>
                    </main>
                </div>
            </div>
        </div>

        <!-- shared modal used by goModal() / postModal() and data-toggle="modal" data-target="#filterModal" -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalTitle">&nbsp;</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <!-- inline cell editor (right click on a list cell); placed by coatstrap.js -->
        <div id="contextMenu" class="card shadow-lg position-fixed z-3 d-none">
            <div class="card-header d-flex align-items-center">
                <span class="panel-info me-auto text-truncate"></span>
                <button type="button" class="btn-close" data-cs-close aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="card-body">
                <div class="panel-data"></div>
                <div class="panel-submit d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-primary flex-fill" onclick="salveaza()"><?= t('ok') ?></button>
                    <button type="button" class="btn btn-outline-secondary flex-fill" data-cs-close><?= t('cancel') ?></button>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <main class="min-vh-100 d-flex align-items-center bg-body-tertiary py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="<?= $authCol ?>" id="csContent">
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-4 fs-4 fw-bold">
                            <span class="badge text-bg-primary p-2 fs-5"><i class="fa-solid fa-shirt fa-fw"></i></span>
                            <span><?= $h($APP_NAME) ?></span>
                        </div>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 p-md-5">
                                <?php
                                if (file_exists("$T/$scriptPage.tpl.php")) include("$T/$scriptPage.tpl.php");
                                elseif (file_exists($scriptPage)) include($scriptPage);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline-secondary border-0 position-fixed top-0 end-0 m-3" type="button" data-cs-theme-toggle aria-label="<?= t('light_dark') ?>"><i class="fa-solid fa-moon"></i></button>
        </main>
    <?php } ?>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="csToasts" aria-live="polite"></div>
</body>

</html>
