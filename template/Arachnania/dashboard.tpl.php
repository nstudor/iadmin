<div class="ar-dashboard">
    <?php if (count($panelRows ?? []) == 0) { ?>
        <div class="card"><div class="card-body ar-empty">
            <i class="fa-solid fa-table-cells-large"></i>
            No dashboard panels yet. Add them in <a href="./dashboard.htm">Dashboard</a> settings.
        </div></div>
    <?php } ?>
    <?php foreach (($panelRows ?? []) as $r) { ?>
        <div class="row g-3">
            <?php foreach ($r['panels'] as $r2) {
                $panelData = $r2['data'] ?? [];
                $panelTpl = db_is_ident($r2['fisier']) && file_exists(__DIR__ . "/dashboard-$r2[fisier].tpl.php") ? __DIR__ . "/dashboard-$r2[fisier].tpl.php" : '';
                $open = ($r2['deschis'] ?? 'Y') != 'N';
            ?>
                <div class="col-12 col-sm-<?= (int)$r2['marimesm'] ?: 12 ?> col-lg-<?= (int)$r2['marimelg'] ?: 12 ?>">
                    <?php if ($r2['vizibil'] == 'Y' && $panelTpl) {
                        if (empty($r2['no_box'])) { ?>
                            <div class="card h-100" rel="<?= (int)$r2['id'] ?>">
                                <div class="card-header">
                                    <span><?= htmlspecialchars($r2['denumire']) ?></span>
                                    <i class="fa-solid fa-chevron-<?= $open ? 'up' : 'down' ?> ar-collapse-btn" role="button" aria-label="Toggle"></i>
                                </div>
                                <div class="card-body"<?= $open ? '' : ' style="display:none"' ?>>
                                    <?php include($panelTpl) ?>
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
    $('.ar-dashboard').on('click', '.ar-collapse-btn', function () {
        var card = $(this).closest('.card');
        var body = card.find('.card-body');
        var wasOpen = body.is(':visible');
        body.slideToggle(200);
        $(this).toggleClass('fa-chevron-up', !wasOpen).toggleClass('fa-chevron-down', wasOpen);
        // remember open / closed (needs modify right on the dashboard module)
        $.post('ajax/modal.php?p=mdoedit-dashboard', { id: card.attr('rel'), field: 'deschis', item: wasOpen ? 'N' : 'Y' });
    });
</script>
