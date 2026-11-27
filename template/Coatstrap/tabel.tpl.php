<?php
// List page: same data / hooks as Badmannahy (header.php, line.php, {field}_show.php, bottom.php),
// shown as a card with a responsive table and a footer with bulk actions + pages (Bootstrap classes only).
$thClass = 'bg-body-tertiary';
$canAdd = ($rcr['add_right'] ?? '') == 'Y';
$canEdit = ($rcr['modify_right'] ?? '') == 'Y';
$canDrop = ($rcr['delete_right'] ?? '') == 'Y';
$iSpecials = [];
foreach ($inlineSpecials ?? [] as $sp => $btn)
    if (in_array($sp, $rcr['details_v'] ?? []))
        $iSpecials[$sp] = $btn;
$rowSpecials = array_values(array_filter($specials ?? [], fn($sp) => in_array($sp, $rcr['details_v'] ?? [])));
$colCount = 2 + count($fields) + (count($iSpecials) > 0 ? 1 : 0);
$pageUrl = function ($i) use ($param) {
    return './' . $param[0] . '-' . $i . (isset($param[2]) ? '-' . implode('-', array_slice($param, 2)) : '') . '.htm';
};
?>
<div class="d-flex flex-wrap align-items-center gap-2 mb-3">
    <?php
    if (file_exists("settings/$pag/header.php")) include("settings/$pag/header.php");
    else echo '<h4 class="mb-0">' . ($title ?? $pag) . '</h4>';
    ?>
    <div class="ms-auto d-flex flex-wrap gap-2">
        <?php if (isset($exportTo) && count($exportTo) > 0) { ?>
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="goModal('export-<?= $pag ?>', '<?= t('export') ?>')">
                <i class="fa-solid fa-download me-1"></i> <?= t('export') ?>
            </button>
        <?php } ?>
        <?php if ($canAdd) { ?>
            <a href="./<?= $param[0] ?>-add.htm" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> <?= t('add') ?></a>
        <?php } ?>
    </div>
</div>

<form action="" method="post" id="multiForm" name="multiForm">
    <input name="multi" type="hidden" value="yes" />
</form>
<?php if (($filtersExists ?? 0) != 0 && ($showFilter ?? '') != 'no') { ?>
    <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post" name="clearfilters">
        <input type="hidden" name="fv" value="999" />
    </form>
<?php } ?>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-sm align-middle text-nowrap mb-0">
            <thead>
                <tr>
                    <th class="<?= $thClass ?>">&nbsp;</th>
                    <?php foreach ($fields as $f) { ?>
                        <th class="<?= $thClass ?>"><?= is_array($f) ? $f['name'] : $f ?></th>
                    <?php } ?>
                    <?php if (count($iSpecials) > 0) { ?>
                        <th class="<?= $thClass ?>">&nbsp;</th>
                    <?php } ?>
                    <th class="<?= $thClass ?> text-center">
                        <input type="checkbox" class="form-check-input" id="ba" onchange="checkAll($(this).is(':checked'))" title="<?= t('select_all') ?>" aria-label="<?= t('select_all') ?>">
                    </th>
                </tr>
                <tr>
                    <th class="<?= $thClass ?> text-center">
                        <?php if (($filtersExists ?? 0) != 0 && ($showFilter ?? '') != 'no') { ?>
                            <button type="button" class="btn btn-sm btn-danger py-0 px-1" onclick="document.clearfilters.submit()" title="<?= t('clear_filters') ?>" aria-label="<?= t('clear_filters') ?>">
                                <i class="fa-solid fa-filter-circle-xmark"></i>
                            </button>
                        <?php } ?>
                    </th>
                    <?php foreach ($fields as $k => $f) { ?>
                        <th class="<?= $thClass ?>">
                            <form action="" method="post" id="ord_<?= $k ?>" class="d-flex align-items-center justify-content-between gap-2">
                                <?php if (($showFilter ?? '') != 'no') { ?>
                                    <i class="fa-solid fa-filter<?= isset($_SESSION['filter'][$k]) ? ' text-warning' : ' opacity-50' ?>" role="button" title="<?= t('filter') ?>" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="goModal('filter-<?= $pag ?>-<?= $k ?>', '<?= t('filter') ?>')"></i>
                                <?php } else { ?><span></span><?php } ?>
                                <input name="order" type="hidden" value="<?= $k ?>" />
                                <?php if (($showOrder ?? '') != 'no') {
                                    if (!isset($_SESSION['order'][$k])) { ?>
                                        <input name="ordertype" type="hidden" value="up" />
                                        <i class="fa-solid fa-sort opacity-50" role="button" title="<?= t('sort') ?>" onclick="$('#ord_<?= $k ?>').submit()"></i>
                                    <?php } else { ?>
                                        <input id="ord_<?= $k ?>_type" name="ordertype" type="hidden" value="<?= ($_SESSION['order'][$k] == 'up' ? 'dn' : 'up') ?>" />
                                        <i class="fa-solid text-warning fa-sort-<?= $_SESSION['order'][$k] == 'up' ? 'up' : 'down' ?>" role="button" title="<?= t('sort_remove') ?>" onclick="$('#ord_<?= $k ?>').submit()" oncontextmenu="$('#ord_<?= $k ?>_type').val('');$('#ord_<?= $k ?>').submit(); return false;"></i>
                                <?php }
                                } ?>
                            </form>
                        </th>
                    <?php } ?>
                    <?php if (count($iSpecials) > 0) { ?>
                        <th class="<?= $thClass ?>">&nbsp;</th>
                    <?php } ?>
                    <th class="<?= $thClass ?>">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!isset($rows) || count($rows ?? []) == 0) { ?>
                    <tr>
                        <td colspan="<?= $colCount ?>" class="text-center text-body-secondary text-wrap py-5">
                            <div>
                                <i class="fa-regular fa-folder-open fa-2x d-block mb-3 opacity-50"></i>
                                <?= $MESSAGE ? $MESSAGE : t('no_records') ?>
                            </div>
                        </td>
                    </tr>
                    <?php } else {
                    foreach ($rows as $r) {
                        $rowClass = '';
                        $cellClass = [];
                        if (file_exists("settings/$pag/line.php")) include("settings/$pag/line.php");
                    ?>
                        <tr class="<?= $rowClass ?>">
                            <td class="text-center">
                                <?php if (count($rowSpecials) > 0 || $canEdit || $canDrop) { ?>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-light py-0 px-2" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" aria-label="<?= t('actions') ?>">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow">
                                            <?php foreach ($rowSpecials as $sp) { ?>
                                                <li><a class="dropdown-item" href="./<?= $param[0] ?>-<?= $sp ?>-id-<?= $r[$id] ?>.htm"><i class="fa fa-<?= $fontawesome[$sp] ?? $sp ?> me-2"></i><?= ucfirst($stitles[$sp] ?? $sp) ?></a></li>
                                            <?php } ?>
                                            <?php if ($canEdit) { ?>
                                                <li><a class="dropdown-item" href="./<?= $param[0] ?>-edit-id-<?= $r[$id] ?>.htm"><i class="fa-solid fa-pen me-2 text-primary"></i><?= t('edit') ?></a></li>
                                            <?php } ?>
                                            <?php if ($canDrop) { ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="./<?= $param[0] ?>-drop-id-<?= $r[$id] ?>.htm"><i class="fa-solid fa-trash me-2"></i><?= t('delete') ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </td>
                            <?php foreach ($fields as $k => $v) { ?>
                                <td<?php if ($canEdit) { ?> class="cell <?= $cellClass[$k] ?? '' ?>" alt="<?= $k . '-' . $r[$id] ?>" title="<?= is_array($v) ? $v['name'] : $v ?>" <?php } else { ?> class="<?= $cellClass[$k] ?? '' ?>" <?php } ?>><?php
                                    if (file_exists("settings/$pag/{$k}_show.php")) include("settings/$pag/{$k}_show.php");
                                    else fieldFormat($k, $v, $r[$k], '', '', $r[$id], $pag);
                                ?></td>
                            <?php } ?>
                            <?php if (count($iSpecials) > 0) { ?>
                                <td class="text-center text-nowrap">
                                    <?php foreach ($iSpecials as $sp => $btn) { ?>
                                        <a href="./<?= $param[0] ?>-<?= $sp ?>-id-<?= $r[$id] ?>.htm" class="btn btn-sm <?= empty($btn) ? 'btn-light' : 'btn-' . $btn ?>" title="<?= ucfirst($stitles[$sp] ?? $sp) ?>"><i class="fa fa-<?= $fontawesome[$sp] ?? $sp ?>"></i></a>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input chboxoper" id="b<?= $r[$id] ?>" name="ids[]" value="<?= $r[$id] ?>" form="multiForm" aria-label="<?= t('select') ?>">
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex flex-wrap align-items-center justify-content-between gap-2">
        <?php if (!isset($dontshowpages) && ($np ?? 0) > 0) { ?>
            <nav aria-label="<?= t('pages') ?>">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item<?= $st == 0 ? ' disabled' : '' ?>"><a class="page-link" href="<?= $pageUrl(0) ?>" aria-label="<?= t('page_first') ?>"><i class="fa-solid fa-angles-left"></i></a></li>
                    <li class="page-item<?= $st == 0 ? ' disabled' : '' ?>"><a class="page-link" href="<?= $pageUrl(max(0, $st - 1)) ?>" aria-label="<?= t('page_previous') ?>"><i class="fa-solid fa-angle-left"></i></a></li>
                    <?php for ($i = $st - 3; $i <= $st + 3; $i++) if ($i >= 0 && $i <= $np) { ?>
                        <li class="page-item<?= $i == $st ? ' active' : '' ?>"><a class="page-link" href="<?= $pageUrl($i) ?>"><?= $i + 1 ?></a></li>
                    <?php } ?>
                    <li class="page-item<?= $st == $np ? ' disabled' : '' ?>"><a class="page-link" href="<?= $pageUrl(min($np, $st + 1)) ?>" aria-label="<?= t('page_next') ?>"><i class="fa-solid fa-angle-right"></i></a></li>
                    <li class="page-item<?= $st == $np ? ' disabled' : '' ?>"><a class="page-link" href="<?= $pageUrl($np) ?>" aria-label="<?= t('page_last') ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                </ul>
            </nav>
        <?php } ?>

        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-end ms-auto">
            <?php if (is_array($multiOper ?? null) || $canDrop) { ?>
                <span class="text-body-secondary small"><?= t('selected') ?></span>
            <?php } ?>
            <?php if (is_array($multiOper ?? null)) foreach ($multiOper as $k => $v) { ?>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="postModal('multi-<?= $pag ?>-<?= $k ?>-<?= $id ?>', '<?= $v ?>', $('#multiForm').serialize())"><?= $v ?></button>
            <?php } ?>
            <?php if ($canDrop) { ?>
                <button class="btn btn-sm btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="postModal('multi-<?= $pag ?>-delete-<?= $id ?>', '<?= t('delete') ?>', $('#multiForm').serialize())"><i class="fa-solid fa-trash me-1"></i><?= t('delete') ?></button>
            <?php } ?>
            <?php if (is_array($multiOper ?? null) || $canDrop) { ?>
                <i class="fa-solid fa-turn-up text-body-secondary px-1" title="<?= t('selected_rows') ?>"></i>
            <?php } ?>
        </div>
    </div>
</div>
<?php if (file_exists("settings/$pag/bottom.php")) include("settings/$pag/bottom.php"); ?>
