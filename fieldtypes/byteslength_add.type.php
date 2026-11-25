<?php if (!empty($fieldDef['fullpage'])) { ?>
    </div>
    </div>
    <div class="row">
        <div class="col col-12 mb-3">
        <?php } ?><textarea name="item[<?php echo $fieldId ?>]" id="textarea<?php echo $fieldId ?>" class="form-control" <?= empty($fieldDef['textareaheight']) ? '' : " style='height: $fieldDef[textareaheight]px'" ?> id="ajaxitem"></textarea>
        <?php if (!empty($fieldDef['richText'])) { ?>
            <script type="text/javascript">
                setTimeout(function() {
                    CKEDITOR.replace('textarea<?php echo $fieldId ?>'<?= empty($fieldDef['textareaheight']) ? '' : ', { height: ' . (int)$fieldDef['textareaheight'] . ' }' ?>);
                }, 0);
            </script>
        <?php } ?>