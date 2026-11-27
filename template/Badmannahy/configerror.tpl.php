<div role="main" class="container theme-showcase" style="margin-top:100px;">
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle float-start" style="font-size: 3rem; padding: 15px;"></i>
        <h3><?= t('config_error') ?></h3>
        <h5><?= sprintf(t('config_error_module'), '<tt>' . htmlspecialchars((string)$pag) . '</tt>') ?></h5>
        <ul class="mb-0">
            <?php foreach ($configErrors ?? [] as $err) { ?>
                <li><?= $err ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
