<?php if($uri!='') { ?>
<div style="position: relative">
<input name="item[<?php echo $fieldId ?>]" type="hidden" id="hidden<?php echo $fieldId ?>" />
<button type="button" class="form-control" id="div<?php echo $fieldId ?>"><?= $fieldValue ?></button>
<input name="file[<?php echo $fieldId ?>]" style="position: absolute; top:0; left: 0; width: 100%; padding: 4px; opacity: 0" type="file" id="hidden<?php echo $fieldId ?>"
       onchange="x=$('#hidden<?php echo $fieldId ?>').val(this.value.replace(/.*[\/\\]/, ''));$('#div<?php echo $fieldId ?>').html(this.value.replace(/.*[\/\\]/, ''))"/>
</div>
<?php } else { ?>
<script>
    setTimeout(
            function() {
                $('#contextMenu').hide();
                goModal('upload-<?= "$fieldDef[uri]-$fieldId-$fieldDef[rowId]"; ?>', 'Upload');
                $('#filterModal').modal('show');
            },0);
</script>
<?php } ?>
