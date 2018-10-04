<textarea name="item[<?php echo $fieldId ?>]" id="textarea<?php echo $fieldId ?>" class="form-control"<?= empty($fieldDef['textareaheight'])?'':" style='height: $fieldDef[textareaheight]px'" ?> id="ajaxitem"><?= $fieldValue ?></textarea>
<?php if($fieldDef['richText']) { ?>
<script type="text/javascript">
setTimeout(function () {
    CKEDITOR.replace( 'textarea<?php echo $fieldId ?>' );
},0);
</script>
<?php } ?>
