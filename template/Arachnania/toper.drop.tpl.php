<form action="" method="post">
    <div class="card ar-page-card border-danger-subtle">
        <div class="card-header bg-danger-subtle text-danger-emphasis">
            <i class="fa-solid fa-trash me-2"></i><?= $title ?? $pag ?> — Stergere
        </div>
        <div class="card-body">
            <input type="hidden" name="item" value="1" />
            <p class="mb-3">Sigur stergi inregistrarea de mai jos?</p>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <tbody>
                        <?php foreach ($dropfields as $k => $v) { ?>
                            <tr>
                                <th class="w-25 text-body-secondary fw-medium"><?= (is_array($v) ? $v['name'] : $v) ?></th>
                                <td>
                                    <?php
                                    if (file_exists("./settings/$pag/{$k}_show.php")) include("./settings/$pag/{$k}_show.php");
                                    elseif (file_exists("./settings_default/$pag/{$k}_show.php")) include("./settings_default/$pag/{$k}_show.php");
                                    else fieldFormat($k, $v, $item[$k] ?? '', '', './');
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="ar-actions">
                <a href="./<?= $param[0] ?>.htm" class="btn btn-outline-secondary"><i class="fa-solid fa-xmark me-1"></i> Anuleaza</a>
                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash me-1"></i> Sterge</button>
            </div>
        </div>
    </div>
</form>
