<form enctype="multipart/form-data" method="post" action="">
    <div class="card ar-page-card">
        <div class="card-header <?= $tmpBackground ?> <?= $tmpText ?>">
            <i class="fa-solid fa-pen me-2"></i><?= $title ?? $pag ?> — Editare
        </div>
        <div class="card-body">
            <?php foreach ($editfields as $k => $v) { ?>
                <div class="row ar-form-row">
                    <div class="col-md-4 ar-form-label"><?= (is_array($v) ? $v['name'] : $v) ?></div>
                    <div class="col-md-8">
                        <?php
                        if (file_exists("./settings/$pag/{$k}_edit.php")) include("./settings/$pag/{$k}_edit.php");
                        elseif (file_exists("./settings_default/$pag/{$k}_edit.php")) include("./settings_default/$pag/{$k}_edit.php");
                        else fieldFormat($k, $v, $item[$k] ?? '', 'edit', './', $item[$id] ?? 0, $pag);
                        ?>
                    </div>
                </div>
            <?php } ?>
            <div class="ar-actions">
                <a href="./<?= $param[0] ?>.htm" class="btn btn-outline-secondary"><i class="fa-solid fa-xmark me-1"></i> Anuleaza</a>
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-check me-1"></i> Salveaza</button>
            </div>
        </div>
    </div>
</form>
