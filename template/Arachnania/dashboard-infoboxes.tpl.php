<div class="row g-3">
    <?php foreach (($panelData ?? []) as $panel) { ?>
        <div class="col">
            <div class="card h-100 bg-<?= $panel['type'] ?? 'body' ?>">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="flex-fill">
                        <div class="h2 fw-bold mb-0 <?= $panel['textValueClass'] ?? '' ?>"><?= $panel['textValue'] ?? '' ?></div>
                        <div class="small <?= $panel['textLabelClass'] ?? '' ?>"><?= $panel['textLabel'] ?? '' ?></div>
                    </div>
                    <i class="<?= $panel['iconClass'] ?? '' ?> fa-2x opacity-75"></i>
                </div>
                <?php if (!empty($panel['linkURL'])) { ?>
                    <div class="card-footer bg-transparent text-end py-2">
                        <a class="small text-decoration-none text-<?= $panel['linkType'] ?? 'primary' ?>" href="<?= $panel['linkURL'] ?>"><?= $panel['linkLabel'] ?? '' ?> &raquo;</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
