<?php
// own password: always allowed, old password required
// another user's password: needs modify_right on utilizatori (rights from the DB)
$isSelf = !empty($item['id']) && ((int)$item['id'] === (int)$_SESSION['userid']);
if (empty($item['id']) || (!$isSelf && !has_right($rcr, 'modify_right'))) {
    die('<div role="alert" class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' . t('no_rights') . '</div>');
}
$err = '';
if (isset($_POST['pass1'])) {
    if ($isSelf && !password_check($_POST['pass0'] ?? '', $item['pass'])) {
        $err = '<div role="alert" class="alert alert-warning">' . t('login_wrong_password') . '</div>';
    } elseif ($_POST['pass1'] != ($_POST['pass2'] ?? '')) {
        $err = '<div role="alert" class="alert alert-warning">' . t('passwords_no_match') . '</div>';
    } elseif (strlen(trim($_POST['pass1'])) < 6) {
        $err = '<div role="alert" class="alert alert-warning">' . t('password_too_short') . '</div>';
    }
    if ($err == '') {
        $err = password_store($item['id'], $_POST['pass1'])
            ? '<div role="alert" class="alert alert-info">' . t('password_changed') . '</div>'
            : '<div role="alert" class="alert alert-danger">' . htmlspecialchars($MESSAGE ?: t('password_not_saved')) . '</div>';
    }
} ?>
    <div class="row m-0">
        <div class="col col-xs-12 col-sm-3">&nbsp;</div>
        <div class="col col-xs-12 col-sm-6">
            <div class="card">
                <div class="card-header bg-info text-light">
                    <b><?= sprintf(t('password_change_for'), '<tt>' . htmlspecialchars((string)$item['user']) . '</tt>') ?></b>
                </div>
                <div class="card-body">
                    <form id="form1" name="form1" method="post" action="">
                    <?php if ($err == '') { ?>
                        <?php if ($isSelf) { ?>
                            <div class="row m-1">
                                <div class="col-4"><?= t('old_password') ?></div>
                                <div class="col-8"><input type="password" name="pass0" class="form-control"/></div>
                            </div>
                        <?php } ?>
                        <div class="row m-1">
                            <div class="col" id="passgen"></div>
                        </div>
                        <div class="row m-1">
                            <div class="col-4"><?= t('new_password') ?></div>
                            <div class="col-8"><input type="password" name="pass1" class="form-control"/></div>
                        </div>
                        <div class="row m-1">
                            <div class="col-4"><?= t('confirm_password') ?></div>
                            <div class="col-8"><input type="password" name="pass2" class="form-control"/></div>
                        </div>
                        <div class="row m-1">
                            <div class="col">
                                <button class="btn btn-info float-left" type="button" onclick="generate()"><?= t('generate') ?>
                                </button>
                                <button class="btn btn-info float-right" type="submit"><?= t('ok') ?></button>
                            </div>
                        </div>
                    <?php } else {
                        echo $err;
                    } ?></form>
                </div>
            </div>
        </div>
    </div>
<script>
    function generate() {
        var st = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        pa = '';
        for (i = 1; i <= 9; i++) {
            j = Math.floor(Math.random() * st.length);
            pa = pa + st[j];
        }
        document.form1.pass1.value = pa;
        document.form1.pass2.value = pa;
        document.getElementById("passgen").innerHTML = '<div role="alert" class="alert alert-info">' + <?= json_encode(t('generated_password')) ?> + ' <tt><strong>' + pa + '</strong></tt></div>';
    }
</script>
<?php
