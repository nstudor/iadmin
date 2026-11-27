<div class="row justify-content-center my-5">
    <div class="col-md-10 col-lg-7 col-xl-6">
        <div class="card border-danger-subtle shadow-sm text-center">
            <div class="card-body p-4 p-md-5">
                <span class="fa-stack fa-2x mb-3">
                    <i class="fa-solid fa-circle fa-stack-2x text-danger opacity-25"></i>
                    <i class="fa-solid fa-screwdriver-wrench fa-stack-1x text-danger"></i>
                </span>
                <h3 class="mb-2"><?= t('config_error') ?></h3>
                <p class="text-body-secondary"><?= sprintf(t('config_error_module'), '<code>' . htmlspecialchars((string)$pag) . '</code>') ?></p>
                <div class="alert alert-danger text-start mb-4">
                    <ul class="mb-0">
                        <?php foreach ($configErrors ?? [] as $err) { ?>
                            <li><?= $err ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <a href="./" class="btn btn-outline-secondary"><i class="fa-solid fa-house me-1"></i> <?= t('dashboard') ?></a>
            </div>
        </div>
    </div>
</div>
