<?php if (count($addfields) == 0) { ?>
    <div class="ar-status">
        <div class="card"><div class="card-body">
            <div class="ar-status-icon bg-warning-subtle text-warning"><i class="fa-solid fa-circle-exclamation"></i></div>
            <h4><?= t('nothing_to_add') ?></h4>
            <a href="./<?= $param[0] ?>.htm" class="btn btn-outline-secondary mt-3"><i class="fa-solid fa-arrow-left me-1"></i> <?= t('back') ?></a>
        </div></div>
    </div>
<?php } else { ?>
    <form enctype="multipart/form-data" method="post" action="">
        <div class="card ar-page-card">
            <div class="card-header bg-gray text-white">
                <i class="fa-solid fa-plus me-2"></i><?= $title ?? $pag ?> — <?= t('form_adding') ?>
            </div>
            <div class="card-body">
                <?php foreach ($addfields as $k => $v) { ?>
                    <div class="row ar-form-row">
                        <div class="col-md-4 ar-form-label"><?= is_array($v) ? $v['name'] : $v ?></div>
                        <div class="col-md-8">
                            <?php
                            if (file_exists("./settings/$pag/{$k}_add.php")) include("./settings/$pag/{$k}_add.php");
                            elseif (file_exists("./settings_default/$pag/{$k}_add.php")) include("./settings_default/$pag/{$k}_add.php");
                            else fieldFormat($k, $v, '', 'add', './');
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="ar-actions">
                    <a href="./<?= $param[0] ?>.htm" class="btn btn-outline-secondary"><i class="fa-solid fa-xmark me-1"></i> <?= t('cancel') ?></a>
                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-check me-1"></i> <?= t('add') ?></button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>
