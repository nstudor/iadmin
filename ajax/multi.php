<?php
$ids = $_POST['ids'];
if (count($ids) == 0) { ?>
    <div role="alert" class="alert alert-danger" style="text-align:center">
        <i class="glyphicon glyphicon-warning-sign" style="font-size:24px; float:right"></i>
        <i class="glyphicon glyphicon-warning-sign" style="font-size:24px; float:left"></i>
        Nimic selectat !
    </div>
<?php die();
}
$operFile = "multi.$pp[2].php";
if (!file_exists($operFile)) $operFile = "../settings/$pag/multi.$pp[2].php";
if (!file_exists($operFile)) $operFile = "../settings_default/$pag/multi.$pp[2].php";
if (!file_exists($operFile)) $operFile = "404.php";
include($operFile);
?>