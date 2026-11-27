<?php if (count($addfields) == 0) { ?>
    <div role="alert" class="alert alert-danger" style="text-align:center">
        <?= t('nothing_to_add') ?>
    </div>
<?php } else { ?>
    <form enctype="multipart/form-data" method="post" action="">
        <div class="container">
            <div class="card">
                <div class="card-header bg-gray text-white">
                    <?= $title ?> - <?= t('form_adding') ?>
                </div>
                <div class="card-body">
                    <?php foreach ($addfields as $k => $v) { ?>
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <?= is_array($v) ? $v['name'] : $v ?>
                            </div>
                            <div class="col-md-7 mb-2">
                                <?php
                                if (file_exists("./settings/$pag/{$k}_add.php"))
                                    include("./settings/$pag/{$k}_add.php");
                                else
        if (file_exists("./settings_default/$pag/{$k}_add.php"))
                                    include("./settings_default/$pag/{$k}_add.php");
                                else
                                    fieldFormat($k, $v, '', 'add', './');
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-success float-end" type="submit"><i class="fas fa-check-circle"></i> <?= t('add') ?></button>
                            <a href="./<?= $param[0] ?>.htm" class="btn btn-danger float-start"><i class="fas fa-times-circle"></i> <?= t('cancel') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } ?>