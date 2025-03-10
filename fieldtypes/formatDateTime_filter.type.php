<?php
    $vl=explode('~', $_SESSION['filter'][$k]);
    $fTypes=[
      3  => 'Egal cu',
      4  => 'Diferit de',
      11 => 'Mai mare ca',
      13 => 'Mai mare sau egal cu',
      12 => 'Mai mic ca',
      14 => 'Mai mic sau egal cu',
      8  => 'Intre',
    ];
    $fieldDef=$fields[$k];
?>
<input name="fv" type="hidden" value="<?= isset($_SESSION['filtertype'][$k])?$_SESSION['filtertype'][$k]:3 ?>" />
    <div class="row">
        <div class="col mb-1">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= isset($fTypes[$_SESSION['filtertype'][$k]*1])?$fTypes[$_SESSION['filtertype'][$k]*1]:$fTypes[3] ?>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<?php foreach($fTypes as $q=>$v) { ?>                  
                  <a class="dropdown-item" onclick="$('#dropdownMenuButton').html('<?= $v ?>'); document.ff.fv.value=<?= $q ?>;$('#selsecond').slide<?= $q!=8?'Up':'Down' ?>()"><?= $v ?></a>
<?php } ?>                
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mb-1">           
<div class="input-group mb-2 mr-sm-2 date">
    <input name="<?php echo $k ?>1" type="text" class="form-control" value="<?= $vl[0]  ?>" />
    <div class="input-group-append">
        <div class="input-group-text"><span class="fa fa-<?= (empty($fieldDef['iconSelect'])?"calendar-alt":$fieldDef['iconSelect']) ?>"></span></div>
    </div>
</div>            
        </div>
        <div class="col mb-1" id="selsecond">
<div class="input-group mb-2 mr-sm-2 date">
    <input name="<?php echo $k ?>2" type="text" class="form-control" value="<?= $vl[1]  ?>" />
    <div class="input-group-append">
        <div class="input-group-text"><span class="fa fa-<?= (empty($fieldDef['iconSelect'])?"calendar-alt":$fieldDef['iconSelect']) ?>"></span></div>
    </div>
</div>            
        </div>
    </div>
    <div class="row">
<input name="<?php echo $k ?>" type="hidden" value="<?= $_SESSION['filter'][$k] ?>" />
<div class="col">
    <button onclick="document.ff.<?php echo $k ?>.value=(document.ff.fv.value!=8?document.ff.<?php echo $k ?>1.value:document.ff.<?php echo $k ?>1.value+'~'+document.ff.<?php echo $k ?>2.value);document.ff.submit()" class='btn btn-secondary col' type="button">     
    <i class="fa fa-check text-white"></i>
    </button>
</div>
<div class="col">
    <button onclick="document.ff.fv.value=5;document.ff.submit()" class='btn btn-danger col' type="button">     
    <i class="fa fa-times text-white"></i>
    </button>
</div>
</div>
<script>
    setTimeout(
            function() {
                $('#selsecond').slide<?= $_SESSION['filtertype'][$k]!=8?'Up':'Down' ?>()
                $('.date').datetimepicker({
                    icons: {
                        time: "fa fa-<?= (empty($fieldDef['iconTime'])?"clock":$fieldDef['iconTime']) ?>",
                        date: "fa fa-<?= (empty($fieldDef['iconDate'])?"calendar":$fieldDef['iconDate']) ?>",
                        up: "fa fa-<?= (empty($fieldDef['iconUp'])?"arrow-up":$fieldDef['iconUp']) ?>",
                        down: "fa fa-<?= (empty($fieldDef['iconDown'])?"arrow-down":$fieldDef['iconDown']) ?>"
                    },
                    locale: '<?= (empty($fieldDef['locale'])?"en":$fieldDef['locale']) ?>',
                    format: '<?= (empty($fieldDef['inputFormat'])?"DD/mm/YYYY":$fieldDef['inputFormat']) ?>'
                });                
            } ,0);
</script>