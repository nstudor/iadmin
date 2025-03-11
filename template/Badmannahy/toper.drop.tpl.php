<form action="" method="post">
    <div class="container">
        <div class="card">
            <div class="card-header bg-maroon text-white">
                <?= $title ?> - Stergere
            </div>
            <div class="card-body">
                <input type="hidden" name="item" value="1" />
                <table class="table table-bordered">
                    <tr>
                        <?php foreach ($dropfields as $k => $v) { ?>
                            <td><?= (is_array($v) ? $v['name'] : $v) ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <?php foreach ($dropfields as $k => $v) { ?>
                            <td>
                                <?php
                                if (file_exists("./settings/$pag/{$k}_show.php"))
                                    include("./settings/$pag/{$k}_show.php");
                                else
        if (file_exists("./settings_default/$pag/{$k}_show.php"))
                                    include("./settings_default/$pag/{$k}_show.php");
                                else
                                    fieldFormat($k, $v, $item[$k], '', './');
                                ?>
                            </td>
                        <?php } ?>
                    </tr>
                </table>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-success float-right" type="submit"><i class="fas fa-check-circle"></i> STERGE</button>
                        <a href="./<?= $param[0] ?>.htm" class="btn btn-danger float-left"><i class="fas fa-times-circle"></i> ANULEAZA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>