<div style="position: relative">
<input name="item[<?php echo $fieldId ?>]" type="hidden" id="hidden<?php echo $fieldId ?>" />
<button type="button" class="form-control" id="div<?php echo $fieldId ?>"><span class="text-muted"><?= isset($fieldDef['buttonText'])?$fieldDef['buttonText']:"Select file" ?></span></button>
<input name="file[<?php echo $fieldId ?>]" style="position: absolute; top:0; left: 0; width: 100%; padding: 4px; opacity: 0" type="file" id="hidden<?php echo $fieldId ?>"
       onchange="x=$('#hidden<?php echo $fieldId ?>').val(this.value.replace(/.*[\/\\]/, ''));$('#div<?php echo $fieldId ?>').html(this.value.replace(/.*[\/\\]/, ''))"/>
</div>