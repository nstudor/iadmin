<?php session_start(); $oper=$pp[1]; $k=$pp[2]; ?>
<form action="./tabel-<?php echo $oper ?>.htm" method="post" name="ff">
<input name="fld" type="hidden" value="<?php echo $k ?>" />
<?php if(file_exists("settings/$oper/{$k}_filter.php")) include("settings/$oper/{$k}_filter.php"); else { ?>
<div class="row">
<div class="col-1">&nbsp;</div>
<div class="col-8 mb-2">
    <input name="<?php echo $k ?>" type="text" class="form-control" value="<?php echo $_SESSION['filter'][$k] ?>" placeholder="Filtrare" />
    <input name="fv" type="hidden" value="<?php echo $_SESSION['filtertype'][$k] ?>" />
</div>

<div class="col-2">
    <button onclick="document.ff.fv.value=5;document.ff.submit()" class='btn btn-danger col' type="button">     
    <i class="fa fa-times text-white"></i>
    </button>
</div>

</div>

<div class="row">
<div class="col-6">
    <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=1;document.ff.submit()"> <i class="fas fa-signature"></i> Asemanator</button>
</div>
<div class="col-6">
    <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=2;document.ff.submit()"> <i class="fab fa-slack-hash"></i> Neasemanator</button>
</div>
<div class="col-6">
    <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=3;document.ff.submit()"> <i class="fas fa-equals"></i> Egal</button>
</div>
<div class="col-6">
    <button class="btn btn-secondary col mb-2" type="button" onclick="document.ff.fv.value=4;document.ff.submit()"> <i class="fas fa-not-equal"></i> Diferit</button>
</div>
</div>

<div class="row">
<div class="col-xs-1 col-sm-4 col-md-4 col-lg-4">&nbsp;</div>
<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
	
</div>
</div>
<?php } ?>
</form>
