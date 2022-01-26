<?php if ($uri != '') {
    if ($fieldDef['fullpage']) { ?>
    </div></div>
    <div class="row"><div class="col col-12 mb-3">
    <?php } ?>

    <textarea name="item[<?php echo $fieldId ?>]" id="textarea<?php echo $fieldId ?>" class="form-control" <?= empty($fieldDef['textareaheight']) ? '' : " style='height: $fieldDef[textareaheight]px;max-height: $fieldDef[textareaheight]px;min-height: $fieldDef[textareaheight]px'" ?> id="ajaxitem"><?= $fieldValue ?></textarea>
    <?php if ($fieldDef['richText']) { ?>
        <script type="text/javascript">
            setTimeout(function() {
                CKEDITOR.replace('textarea<?php echo $fieldId ?>');
            }, 0);
        </script>
    <?php } ?>
<?php } else { ?>
    <script>
        setTimeout(
            function() {
                $('#contextMenu').hide();
                goModal('upload-<?= "$fieldDef[uri]-$fieldId-$fieldDef[rowId]"; ?>', 'Upload');
                $('#filterModal').modal('show');
            }, 0);
    </script>
<?php } ?>