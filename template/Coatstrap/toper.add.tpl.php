<?php if (count($addfields) == 0) { ?>
    <div class="row justify-content-center my-5">
        <div class="col-md-10 col-lg-7 col-xl-6">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-4 p-md-5">
                    <span class="fa-stack fa-2x mb-3">
                        <i class="fa-solid fa-circle fa-stack-2x text-warning opacity-25"></i>
                        <i class="fa-solid fa-circle-exclamation fa-stack-1x text-warning"></i>
                    </span>
                    <h4><?= t('nothing_to_add') ?></h4>
                    <a href="./<?= $param[0] ?>.htm" class="btn btn-outline-secondary mt-3"><i class="fa-solid fa-arrow-left me-1"></i> <?= t('back') ?></a>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row justify-content-center">
        <div class="col-xl-9 col-xxl-8">
            <form enctype="multipart/form-data" method="post" action="">
                <div class="card shadow-sm">
                    <div class="card-header fw-semibold">
                        <i class="fa-solid fa-plus me-2"></i><?= $title ?? $pag ?> — <?= t('form_adding') ?>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($addfields as $k => $v) { ?>
                            <li class="list-group-item">
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-4 fw-medium text-body-secondary"><?= is_array($v) ? $v['name'] : $v ?></div>
                                    <div class="col-md-8">
                                        <?php
                                        if (file_exists("./settings/$pag/{$k}_add.php")) include("./settings/$pag/{$k}_add.php");
                                        elseif (file_exists("./settings_default/$pag/{$k}_add.php")) include("./settings_default/$pag/{$k}_add.php");
                                        else fieldFormat($k, $v, '', 'add', './');
                                        ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="card-footer d-flex justify-content-between gap-2">
                        <a href="./<?= $param[0] ?>.htm" class="btn btn-outline-secondary"><i class="fa-solid fa-xmark me-1"></i> <?= t('cancel') ?></a>
                        <button class="btn btn-success" type="submit"><i class="fa-solid fa-check me-1"></i> <?= t('add') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
