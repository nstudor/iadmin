<form enctype="multipart/form-data" method="post" action="">
    <div class="container">
        <div class="card">
            <div class="card-header bg-gray text-white">
                <?= $title ?> - <?= t('form_editing') ?>
            </div>
            <div class="card-body">
                <?php foreach ($editfields as $k => $v) { ?>
                    <div class="row">
                        <div class="col col-5 mb-2"><?= (is_array($v) ? $v['name'] : $v) ?></div>
                        <div class="col col-7 mb-2">
                            <?php
                            if (file_exists("./settings/$pag/{$k}_edit.php"))
                                include("./settings/$pag/{$k}_edit.php");
                            else
        if (file_exists("./settings_default/$pag/{$k}_edit.php"))
                                include("./settings_default/$pag/{$k}_edit.php");
                            else
                                fieldFormat($k, $v, $item[$k] ?? '', 'edit', './', $item[$id] ?? 0, $pag);
                            ?></div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-success float-end" type="submit"><i class="fas fa-check-circle"></i> <?= t('save') ?></button>
                        <a href="./<?= $param[0] ?>.htm" class="btn btn-danger float-start"><i class="fas fa-times-circle"></i> <?= t('cancel') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>