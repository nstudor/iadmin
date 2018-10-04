<label class="sr-only" for="<?php echo $fieldId ?>DateTimePicker">Username</label>
<div class="input-group mb-2 mr-sm-2 date" id="<?php echo $fieldId ?>DateTimePicker">
    <input name="item[<?php echo $fieldId ?>]" type="text" class="form-control" id="ajaxitem" value="<?= $fieldValue ?>" />
    <div class="input-group-append">
        <div class="input-group-text"><span class="fa fa-<?= (empty($fieldDef['iconSelect'])?"calendar-alt":$fieldDef['iconSelect']) ?>"></span></div>
    </div>
</div>
<script type="text/javascript">
setTimeout(function () {
    $('#<?php echo $fieldId ?>DateTimePicker').datetimepicker({
        icons: {
            time: "fa fa-<?= (empty($fieldDef['iconTime'])?"clock":$fieldDef['iconTime']) ?>",
            date: "fa fa-<?= (empty($fieldDef['iconDate'])?"calendar":$fieldDef['iconDate']) ?>",
            up: "fa fa-<?= (empty($fieldDef['iconUp'])?"arrow-up":$fieldDef['iconUp']) ?>",
            down: "fa fa-<?= (empty($fieldDef['iconDown'])?"arrow-down":$fieldDef['iconDown']) ?>"
        },
        locale: '<?= (empty($fieldDef['locale'])?"en":$fieldDef['locale']) ?>',
        format: '<?= (empty($fieldDef['inputFormat'])?"DD/mm/YYYY":$fieldDef['inputFormat']) ?>'
    });
},0);
</script>