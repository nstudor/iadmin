<div class="ar-status">
    <div class="card border-danger-subtle"><div class="card-body">
        <div class="ar-status-icon bg-danger-subtle text-danger"><i class="fa-solid fa-screwdriver-wrench"></i></div>
        <h3 class="mb-2"><?= t('config_error') ?></h3>
        <p class="text-body-secondary"><?= sprintf(t('config_error_module'), '<code>' . htmlspecialchars((string)$pag) . '</code>') ?></p>
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                <?php foreach ($configErrors ?? [] as $err) { ?>
                    <li><?= $err ?></li>
                <?php } ?>
            </ul>
        </div>
        <a href="./" class="btn btn-outline-secondary"><i class="fa-solid fa-house me-1"></i> <?= t('dashboard') ?></a>
    </div></div>
</div>
