<?php
// List page: same data / hooks as Badmannahy (header.php, line.php, {field}_show.php, bottom.php),
// shown as a card with a scrolling table, sticky header and a footer with bulk actions + pages.
$thClass = trim("$tmpBackground $tmpText");
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
<div class="ar-list-head">
    <?php
    if (file_exists("settings/$pag/header.php")) include("settings/$pag/header.php");
    else echo '<h4>' . ($title ?? $pag) . '</h4>';
    ?>
    <div class="ar-list-tools">
        <?php if (isset($exportTo) && count($exportTo) > 0) { ?>
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="goModal('export-<?= $pag ?>', 'Export')">
                <i class="fa-solid fa-download me-1"></i> Export
            </button>
        <?php } ?>
        <?php if ($canAdd) { ?>
            <a href="./<?= $param[0] ?>-add.htm" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Adauga</a>
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

<div class="card">
    <div class="ar-table-wrap">
        <table class="table table-hover table-striped table-sm align-middle ar-table">
            <thead>
                <tr>
                    <th class="<?= $thClass ?>" style="width:3rem">&nbsp;</th>
                    <?php foreach ($fields as $f) { ?>
                        <th class="<?= $thClass ?>"><?= is_array($f) ? $f['name'] : $f ?></th>
                    <?php } ?>
                    <?php if (count($iSpecials) > 0) { ?>
                        <th class="<?= $thClass ?>">&nbsp;</th>
                    <?php } ?>
                    <th class="<?= $thClass ?> text-center" style="width:2.5rem">
                        <input type="checkbox" id="ba" onchange="checkAll($(this).is(':checked'))">
                        <label for="ba" title="Select all"></label>
                    </th>
                </tr>
                <tr class="ar-tools-row">
                    <th class="<?= $thClass ?> text-center">
                        <?php if (($filtersExists ?? 0) != 0 && ($showFilter ?? '') != 'no') { ?>
                            <span class="fa-stack" onclick="document.clearfilters.submit()" style="cursor:pointer" title="Clear filters">
                                <i class="fa-solid fa-filter text-warning fa-stack-1x"></i>
                                <i class="fa-solid fa-ban fa-stack-1x fa-lg text-danger"></i>
                            </span>
                        <?php } ?>
                    </th>
                    <?php foreach ($fields as $k => $f) { ?>
                        <th class="<?= $thClass ?>">
                            <form action="" method="post" id="ord_<?= $k ?>" class="ar-th-tools">
                                <?php if (($showFilter ?? '') != 'no') { ?>
                                    <i class="fa-solid fa-filter<?= isset($_SESSION['filter'][$k]) ? ' ar-on text-warning' : '' ?>" title="Filtrare" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="goModal('filter-<?= $pag ?>-<?= $k ?>', 'Filtrare')"></i>
                                <?php } else { ?><span></span><?php } ?>
                                <input name="order" type="hidden" value="<?= $k ?>" />
                                <?php if (($showOrder ?? '') != 'no') {
                                    if (!isset($_SESSION['order'][$k])) { ?>
                                        <input name="ordertype" type="hidden" value="up" />
                                        <i class="fa-solid fa-sort" title="Sort" onclick="$('#ord_<?= $k ?>').submit()"></i>
                                    <?php } else { ?>
                                        <input id="ord_<?= $k ?>_type" name="ordertype" type="hidden" value="<?= ($_SESSION['order'][$k] == 'up' ? 'dn' : 'up') ?>" />
                                        <i class="fa-solid ar-on text-warning fa-sort-<?= $_SESSION['order'][$k] == 'up' ? 'up' : 'down' ?>" title="Sort (right click: remove)" onclick="$('#ord_<?= $k ?>').submit()" oncontextmenu="$('#ord_<?= $k ?>_type').val('');$('#ord_<?= $k ?>').submit(); return false;"></i>
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
                        <td colspan="<?= $colCount ?>">
                            <div class="ar-empty">
                                <i class="fa-regular fa-folder-open"></i>
                                <?= $MESSAGE ? $MESSAGE : 'No records to show !' ?>
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
                            <td class="text-center ar-row-actions">
                                <?php if (count($rowSpecials) > 0 || $canEdit || $canDrop) { ?>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" aria-label="Actions">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($rowSpecials as $sp) { ?>
                                                <li><a class="dropdown-item" href="./<?= $param[0] ?>-<?= $sp ?>-id-<?= $r[$id] ?>.htm"><i class="fa fa-<?= $fontawesome[$sp] ?? $sp ?> me-2"></i><?= ucfirst($stitles[$sp] ?? $sp) ?></a></li>
                                            <?php } ?>
                                            <?php if ($canEdit) { ?>
                                                <li><a class="dropdown-item" href="./<?= $param[0] ?>-edit-id-<?= $r[$id] ?>.htm"><i class="fa-solid fa-pen me-2 text-primary"></i>Editeaza</a></li>
                                            <?php } ?>
                                            <?php if ($canDrop) { ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="./<?= $param[0] ?>-drop-id-<?= $r[$id] ?>.htm"><i class="fa-solid fa-trash me-2"></i>Sterge</a></li>
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
                                <input type="checkbox" class="chboxoper" id="b<?= $r[$id] ?>" name="ids[]" value="<?= $r[$id] ?>" form="multiForm">
                                <label for="b<?= $r[$id] ?>"></label>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <div class="ar-list-foot">
        <?php if (!isset($dontshowpages) && ($np ?? 0) > 0) { ?>
            <nav aria-label="Pagini">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item<?= $st == 0 ? ' disabled' : '' ?>"><a class="page-link" href="<?= $pageUrl(0) ?>" aria-label="First"><i class="fa-solid fa-angles-left"></i></a></li>
                    <li class="page-item<?= $st == 0 ? ' disabled' : '' ?>"><a class="page-link" href="<?= $pageUrl(max(0, $st - 1)) ?>" aria-label="Previous"><i class="fa-solid fa-angle-left"></i></a></li>
                    <?php for ($i = $st - 3; $i <= $st + 3; $i++) if ($i >= 0 && $i <= $np) { ?>
                        <li class="page-item<?= $i == $st ? ' active' : '' ?>"><a class="page-link" href="<?= $pageUrl($i) ?>"><?= $i + 1 ?></a></li>
                    <?php } ?>
                    <li class="page-item<?= $st == $np ? ' disabled' : '' ?>"><a class="page-link" href="<?= $pageUrl(min($np, $st + 1)) ?>" aria-label="Next"><i class="fa-solid fa-angle-right"></i></a></li>
                    <li class="page-item<?= $st == $np ? ' disabled' : '' ?>"><a class="page-link" href="<?= $pageUrl($np) ?>" aria-label="Last"><i class="fa-solid fa-angles-right"></i></a></li>
                </ul>
            </nav>
        <?php } ?>

        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-end ms-auto">
            <?php if (is_array($multiOper ?? null) || $canDrop) { ?>
                <span class="text-body-secondary small">Selectate:</span>
            <?php } ?>
            <?php if (is_array($multiOper ?? null)) foreach ($multiOper as $k => $v) { ?>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="postModal('multi-<?= $pag ?>-<?= $k ?>-<?= $id ?>', '<?= $v ?>', $('#multiForm').serialize())"><?= $v ?></button>
            <?php } ?>
            <?php if ($canDrop) { ?>
                <button class="btn btn-sm btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#filterModal" onclick="postModal('multi-<?= $pag ?>-delete-<?= $id ?>', 'Sterge', $('#multiForm').serialize())"><i class="fa-solid fa-trash me-1"></i>Sterge</button>
            <?php } ?>
            <?php if (is_array($multiOper ?? null) || $canDrop) { ?>
                <i class="fa-solid fa-turn-up text-body-secondary ar-sel-arrow" title="Selected rows"></i>
            <?php } ?>
        </div>
    </div>
</div>
<?php if (file_exists("settings/$pag/bottom.php")) include("settings/$pag/bottom.php"); ?>
