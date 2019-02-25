<?php
if ($_SESSION['rights']['modify_right'] != 'Y') {
    if ($_SESSION['userid'] != $param[4]) {
        die('<div role="alert" class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ERROR: No rights !</div>');
    }
}
$err = '';

if (isset($_POST['pass0'])) {
    if (md5($_POST['pass0']) != $item['pass']) {
        $err = '<div role="alert" class="alert alert-warning">Wrong password</div>';
    }
}
if (isset($_POST['pass1']) && $err == '') {

    if ($_POST['pass1'] != $_POST['pass2']) {
        $err = '<div role="alert" class="alert alert-warning">Passwords do not match !</div>';
    }

    if (strlen(trim($_POST['pass1'])) < 6) {
        $err = '<div role="alert" class="alert alert-warning">Password too short !</div>';
    }

    if ($err == '') {
        db_update(['pass' => md5($_POST['pass1'])], 'login_users', 'id=' . $item['id']);
        $err = '<div role="alert" class="alert alert-info">Password changed !</div>';
    }
} ?>
    <div class="row m-0">
        <div class="col col-xs-12 col-sm-3">&nbsp;</div>
        <div class="col col-xs-12 col-sm-6">
            <div class="card">
                <div class="card-header bg-info text-light">
                    <b>Password change for user <tt><?php echo $item['user'] ?></tt></b>
                </div>
                <div class="card-body">
                    <form id="form1" name="form1" method="post" action="">
                    <?php if ($err == '') { ?>
                        <?php if ($_SESSION['userid'] == $param[4]) { ?>
                            <div class="row m-1">
                                <div class="col-4">Old password</div>
                                <div class="col-8"><input type="password" name="pass0" class="form-control"/></div>
                            </div>
                        <?php } ?>
                        <div class="row m-1">
                            <div class="col" id="passgen"></div>
                        </div>
                        <div class="row m-1">
                            <div class="col-4">New password</div>
                            <div class="col-8"><input type="password" name="pass1" class="form-control"/></div>
                        </div>
                        <div class="row m-1">
                            <div class="col-4">Confirm password</div>
                            <div class="col-8"><input type="password" name="pass2" class="form-control"/></div>
                        </div>
                        <div class="row m-1">
                            <div class="col">
                                <button class="btn btn-info float-left" type="button" onclick="generate()">GENERATE
                                </button>
                                <button class="btn btn-info float-right" type="submit">OK</button>
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
        document.getElementById("passgen").innerHTML = '<div role="alert" class="alert alert-info">Generated password: <tt><strong>' + pa + '</strong></tt></div>';
    }
</script>


<?php
/*
$err='NO';
if(isset($_POST['pass1'])) {
	$err='';
	if(strlen($_POST['pass1'])<6) $err='Parola este prea scurta (minim 6 caractere)!';
	if($_POST['pass1']!=$_POST['pass2']) $err='Parolele nu coincid !';
}

if($err=='') { 
mysql_query("UPDATE login_users SET pass=md5('".$_POST['pass2']."') WHERE id=".$_GET['id']);
?><div role="alert" class="alert alert-success"><a href="./?p=tabel-<?php echo $pag ?>" class="btn btn-<?php echo $theme ?>" style="float:right">OK</a> Parola schimbata cu succes ! </div><?php
} else {
$title="Schimbare parola";
?>

<?php if($err!='NO') { ?><?php } ?>

<h3>Schimbare parola pentru userul <tt><?php echo $item['user'] ?></tt></h3>
<div class="col-xs-1 col-sm-2 col-lg-3">&nbsp;</div>

<div class="col-xs-10 col-sm-8 col-lg-6">
<div class="row spc">
<div class="col-xs-4 col-sm-4 col-lg-4">Parola noua</div>
<div class="col-xs-8 col-sm-8 col-lg-8"><input type="password" name="pass1" class="form-control" /></div>
</div>
<div class="row spc">
<div class="col-xs-4 col-sm-4 col-lg-4">Confirmare parola</div>
<div class="col-xs-8 col-sm-8 col-lg-8"><input type="password" name="pass2" class="form-control" /></div>
</div>


<div class="row spc">
<div class="col-xs-3 col-sm-3 col-lg-3"><button class="btn btn-<?php echo $theme ?> spc" type="button" onclick="generate()">Generare</button></div>
<div class="col-xs-3 col-sm-3 col-lg-3">&nbsp;</div>
<div class="col-xs-3 col-sm-3 col-lg-3"><button class="btn btn-<?php echo $theme ?> spc" type="submit">OK</button></div>
<div class="col-xs-3 col-sm-3 col-lg-3"><a class="btn btn-<?php echo $theme ?> spc" href="./?p=tabel-<?php echo $pag ?>">Cancel</a></div>
</div>
<div class="row spc" id="passgen">
</div>
</form>
</div>
<?php } */ ?>
