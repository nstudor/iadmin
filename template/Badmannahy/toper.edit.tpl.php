<form enctype="multipart/form-data" method="post" action="">
<div class="container">
    <div class="card">
        <div class="card-header bg-info text-white">
            <?= $title ?> - Editare
        </div>
        <div class="card-body">
<?php foreach($editfields as $k=>$v) { ?>
            <div class="row">
                <div class="col col-5 mb-2"><?= (is_array($v)?$v['name']:$v) ?></div>
                <div class="col col-7 mb-2">
<?php
    if(file_exists("./settings/$pag/{$k}_edit.php")) 
        include("./settings/$pag/{$k}_edit.php"); 
    else
        if(file_exists("./settings_default/$pag/{$k}_edit.php")) 
            include("./settings_default/$pag/{$k}_edit.php"); 
        else
            fieldFormat($k, $v, $item[$k], 'edit','./');
?></div>
            </div>
<?php } ?>            
            <div class="row">
                <div class="col">
                    <button class="btn btn-success float-right" type="submit"><i class="fas fa-check-circle"></i> SALVEAZA</button>
                    <a href="./tabel-<?= $param[1] ?>.htm" class="btn btn-danger float-left"><i class="fas fa-times-circle"></i> ANULEAZA</a>
                </div>
            </div>  
        </div>
    </div>
</div>
</form>