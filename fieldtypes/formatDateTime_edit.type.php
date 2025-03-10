<div class='input-group' id='<?= $fieldId ?>DateTimePicker' data-td-target-input='nearest' data-td-target-toggle='nearest'>
    <input id='<?= $fieldId ?>DateTimePickerInput' type='hidden' class='form-control w-100' data-td-target='#<?= $fieldId ?>DateTimePicker' />
    <input name="item[<?= $fieldId ?>]" type="hidden" id="ajaxitem" value="<?= $fieldValue ?>" class="iteminput" />
</div>
<script type="text/javascript">
    setTimeout(function() {
        $('#<?= $fieldId ?>DateTimePicker').tempusDominus({
            localization: {
                locale: '<?= (empty($fieldDef['locale']) ? "en" : $fieldDef['locale']) ?>',
            },
            display: {
                inline: true,
                sideBySide: <?= (empty($fieldDef['sideBySide']) ? "true" : $fieldDef['sideBySide']) ?>,
                components: {
                    calendar: <?= (empty($fieldDef['calendar']) ? "true" : $fieldDef['calendar']) ?>,
                    clock: <?= (empty($fieldDef['clock']) ? "true" : $fieldDef['clock']) ?>,
                    seconds: <?= (empty($fieldDef['seconds']) ? "true" : $fieldDef['seconds']) ?>,
                    useTwentyfourHour: <?= (empty($fieldDef['use24Hour']) ? "true" : $fieldDef['use24Hour']) ?>,
                }
            },
            defaultDate: '<?= date('Y-m-d H:i:s', strtotime($fieldValue)) ?>',
            hooks: {
                inputFormat: (context, date) => {
                    d = date.getFullYear() + '-' + (1 + date.getMonth()) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
                    $('#<?= $fieldId ?>DateTimePicker .iteminput').val(d);
                    return d; //ate.toISOString().split('T').join(' ').split('.')[0];
                }
            }
        });
    }, 0);
</script>