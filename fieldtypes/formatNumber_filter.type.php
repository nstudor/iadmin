<?php
$vl = explode('~', $_SESSION['filter'][$k]);
$fTypes = [
    3  => 'Egal cu',
    4  => 'Diferit de',
    11 => 'Mai mare ca',
    13 => 'Mai mare sau egal cu',
    12 => 'Mai mic ca',
    14 => 'Mai mic sau egal cu',
    8  => 'Intre',
];
?>
<input name="fv" type="hidden" value="<?= isset($_SESSION['filtertype'][$k]) ? $_SESSION['filtertype'][$k] : 3 ?>" />
<div class="row">
    <div class="col-8 mb-1">
        <div class="row">
            <div class="col mb-1">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= isset($fTypes[$_SESSION['filtertype'][$k] * 1]) ? $fTypes[$_SESSION['filtertype'][$k] * 1] : $fTypes[3] ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php foreach ($fTypes as $q => $v) { ?>
                            <a class="dropdown-item" onclick="$('#dropdownMenuButton').html('<?= $v ?>'); document.ff.fv.value=<?= $q ?>;$('#selsecond').slide<?= $q != 8 ? 'Up' : 'Down' ?>()"><?= $v ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col mb-1">
                <input name="<?php echo $k ?>1" type="text" class="form-control" value="<?= $vl[0]  ?>" />
            </div>
            <div class="col mb-1" id="selsecond">
                <input name="<?php echo $k ?>2" type="text" class="form-control" value="<?= $vl[1]  ?>" />
            </div>
        </div>
    </div>
    <input name="<?php echo $k ?>" type="hidden" value="<?= $_SESSION['filter'][$k] ?>" />
    <div class="col-2">
        <button onclick="document.ff.<?php echo $k ?>.value=(document.ff.fv.value!=8?document.ff.<?php echo $k ?>1.value:document.ff.<?php echo $k ?>1.value+'~'+document.ff.<?php echo $k ?>2.value);document.ff.submit()" class='btn btn-secondary col' type="button">
            <i class="fa fa-check <?= $tmpText ?>"></i>
        </button>
    </div>
    <div class="col-2">
        <button onclick="document.ff.fv.value=5;document.ff.submit()" class='btn btn-danger col' type="button">
            <i class="fa fa-times <?= $tmpText ?>"></i>
        </button>
    </div>
</div>
<script>
    setTimeout(
        function() {
            $('#selsecond').slide<?= $_SESSION['filtertype'][$k] != 8 ? 'Up' : 'Down' ?>()
        }, 0);
</script>