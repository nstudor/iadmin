<div id="csDashboard">
    <?php if (count($panelRows ?? []) == 0) { ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center text-body-secondary py-5">
                <i class="fa-solid fa-table-cells-large fa-2x d-block mb-3 opacity-50"></i>
                <?= sprintf(t('no_dashboard_panels'), '<a href="./dashboard.htm">' . t('dashboard') . '</a>') ?>
            </div>
        </div>
    <?php } ?>
    <?php foreach (($panelRows ?? []) as $r) { ?>
        <div class="row g-3 mb-3">
            <?php foreach ($r['panels'] as $r2) {
                $panelData = $r2['data'] ?? [];
                $panelTpl = db_is_ident($r2['fisier']) && file_exists(__DIR__ . "/dashboard-$r2[fisier].tpl.php") ? __DIR__ . "/dashboard-$r2[fisier].tpl.php" : '';
                $open = ($r2['deschis'] ?? 'Y') != 'N';
                $pid = (int)$r2['id'];
            ?>
                <div class="col-12 col-sm-<?= (int)$r2['marimesm'] ?: 12 ?> col-lg-<?= (int)$r2['marimelg'] ?: 12 ?>">
                    <?php if ($r2['vizibil'] == 'Y' && $panelTpl) {
                        if (empty($r2['no_box'])) { ?>
                            <div class="card shadow-sm">
                                <div class="card-header d-flex align-items-center justify-content-between fw-semibold">
                                    <span><?= htmlspecialchars($r2['denumire']) ?></span>
                                    <button type="button" class="btn btn-sm btn-link link-body-emphasis p-0" data-bs-toggle="collapse" data-bs-target="#csPanel<?= $pid ?>" aria-expanded="<?= $open ? 'true' : 'false' ?>" aria-controls="csPanel<?= $pid ?>" aria-label="<?= t('toggle') ?>">
                                        <i class="fa-solid fa-chevron-<?= $open ? 'up' : 'down' ?>"></i>
                                    </button>
                                </div>
                                <div class="collapse<?= $open ? ' show' : '' ?>" id="csPanel<?= $pid ?>" data-cs-panel="<?= $pid ?>">
                                    <div class="card-body">
                                        <?php include($panelTpl) ?>
                                    </div>
                                </div>
                            </div>
                    <?php } else include($panelTpl);
                    } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<script>
    // remember open / closed (needs modify right on the dashboard module)
    $('#csDashboard').on('shown.bs.collapse hidden.bs.collapse', '[data-cs-panel]', function (e) {
        if (e.target !== this) return;
        var open = e.type === 'shown';
        $('[data-bs-target="#' + this.id + '"] i').toggleClass('fa-chevron-up', open).toggleClass('fa-chevron-down', !open);
        $.post('ajax/modal.php?p=mdoedit-dashboard', { id: $(this).data('cs-panel'), field: 'deschis', item: open ? 'Y' : 'N' });
    });
</script>
