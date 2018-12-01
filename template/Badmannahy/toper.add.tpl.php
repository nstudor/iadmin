<?php if( count($addfields)==0) { ?>
<div role="alert" class="alert alert-danger" style="text-align:center">
 Nothing set for adding !
</div>
<?php } else  { ?>
<form action="" method="post" >
<div class="container">
    <div class="card">
        <div class="card-header bg-info text-white">
            <?= $title ?> - Adaugare
        </div>
        <div class="card-body">
<?php foreach($addfields as $k=>$v) { ?>
    <div class="row">
        <div class="col-md-5 mb-2">
            <?= is_array($v)?$v['name']:$v ?>
        </div>
        <div class="col-md-7 mb-2">
<?php
    if(file_exists("../settings/$pag/{$k}_add.php"))
        include("settings/$pag/{$k}_add.php"); 
    else
        if(file_exists("../settings_default/$pag/{$k}_add.php"))
            include("settings_default/$pag/{$k}_add.php"); 
        else
            fieldFormat($k, $v, '', 'add', './');
?>
        </div>
    </div>
<?php } ?>
            <div class="row">
                <div class="col">
                    <button class="btn btn-success float-right" type="submit"><i class="fas fa-check-circle"></i> ADAUGA</button>
                    <a href="./tabel-<?= $param[1] ?>.htm" class="btn btn-danger float-left"><i class="fas fa-times-circle"></i> ANULEAZA</a>
                </div>
            </div>            
        </div>
    </div>            
</div>
</form>
<?php } ?>

