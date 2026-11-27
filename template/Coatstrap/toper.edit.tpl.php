<div class="row justify-content-center">
    <div class="col-xl-9 col-xxl-8">
        <form enctype="multipart/form-data" method="post" action="">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    <i class="fa-solid fa-pen me-2"></i><?= $title ?? $pag ?> — <?= t('form_editing') ?>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($editfields as $k => $v) { ?>
                        <li class="list-group-item">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-4 fw-medium text-body-secondary"><?= (is_array($v) ? $v['name'] : $v) ?></div>
                                <div class="col-md-8">
                                    <?php
                                    if (file_exists("./settings/$pag/{$k}_edit.php")) include("./settings/$pag/{$k}_edit.php");
                                    elseif (file_exists("./settings_default/$pag/{$k}_edit.php")) include("./settings_default/$pag/{$k}_edit.php");
                                    else fieldFormat($k, $v, $item[$k] ?? '', 'edit', './', $item[$id] ?? 0, $pag);
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <div class="card-footer d-flex justify-content-between gap-2">
                    <a href="./<?= $param[0] ?>.htm" class="btn btn-outline-secondary"><i class="fa-solid fa-xmark me-1"></i> <?= t('cancel') ?></a>
                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-check me-1"></i> <?= t('save') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
