<?php
    $vl=explode('~', (string)($_SESSION['filter'][$k] ?? '')) + ['', ''];
    $fType=(int)($_SESSION['filtertype'][$k] ?? 3);
    $fTypes=[
      3  => t('filter_eq'),
      4  => t('filter_ne'),
      11 => t('filter_gt'),
      13 => t('filter_ge'),
      12 => t('filter_lt'),
      14 => t('filter_le'),
      8  => 'Intre',
    ];
    $fieldDef=$fields[$k];
?>
<input name="fv" type="hidden" value="<?= $fType ?>" />
    <div class="row">
        <div class="col mb-1">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $fTypes[$fType] ?? $fTypes[3] ?>
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
<div class="input-group mb-2 mr-sm-2 date" data-td-target-input="nearest" data-td-target-toggle="nearest">
    <input name="<?php echo $k ?>1" type="text" class="form-control" value="<?= $vl[0]  ?>" />
    <div class="input-group-append">
        <div class="input-group-text" data-td-toggle="datetimepicker"><span class="fa fa-<?= (empty($fieldDef['iconSelect'])?"calendar-alt":$fieldDef['iconSelect']) ?>"></span></div>
    </div>
</div>            
        </div>
        <div class="col mb-1" id="selsecond">
<div class="input-group mb-2 mr-sm-2 date" data-td-target-input="nearest" data-td-target-toggle="nearest">
    <input name="<?php echo $k ?>2" type="text" class="form-control" value="<?= $vl[1]  ?>" />
    <div class="input-group-append">
        <div class="input-group-text" data-td-toggle="datetimepicker"><span class="fa fa-<?= (empty($fieldDef['iconSelect'])?"calendar-alt":$fieldDef['iconSelect']) ?>"></span></div>
    </div>
</div>            
        </div>
    </div>
    <div class="row">
<input name="<?php echo $k ?>" type="hidden" value="<?= $_SESSION['filter'][$k] ?? '' ?>" />
<div class="col">
    <button onclick="document.ff.<?php echo $k ?>.value=(document.ff.fv.value!=8?document.ff.<?php echo $k ?>1.value:document.ff.<?php echo $k ?>1.value+'~'+document.ff.<?php echo $k ?>2.value);document.ff.submit()" class='btn btn-secondary col' type="button">     
    <i class="fa fa-check"></i>
    </button>
</div>
<div class="col">
    <button onclick="document.ff.fv.value=5;document.ff.submit()" class='btn btn-danger col' type="button">     
    <i class="fa fa-times"></i>
    </button>
</div>
</div>
<script>
    setTimeout(
            function() {
                $('#selsecond').slide<?= $fType != 8 ? 'Up' : 'Down' ?>();
                // date pickers (Tempus Dominus) writing YYYY-MM-DD into the inputs
                $('#filterModal .date').each(function() {
                    $(this).tempusDominus({
                        localization: { locale: '<?= (empty($fieldDef['locale']) ? "en" : $fieldDef['locale']) ?>' },
                        display: { components: { clock: false } },
                        hooks: {
                            inputFormat: (context, date) => date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0')
                        }
                    });
                });                
            } ,0);
</script>