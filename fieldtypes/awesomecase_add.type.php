<?php
if (!empty($fieldDef['template'])) include('awesomecase/' . $fieldDef['template'] . '.tpl.type.php');

if (!is_array($fieldDef['values'])) $fieldDef['values'] = explode(',', $fieldDef['values']);
if (!is_array($fieldDef['chars'])) $fieldDef['chars'] = explode(',', $fieldDef['chars']);
if (!is_array($fieldDef['colors'])) $fieldDef['colors'] = explode(',', $fieldDef['colors']);
if (!is_array($fieldDef['classes'])) $fieldDef['classes'] = explode(',', $fieldDef['classes']);
if (!is_array($fieldDef['fatype'])) $fieldDef['fatype'] = explode(',', $fieldDef['fatype']);

foreach ($fieldDef['values'] as $k => $v) {
    $fieldDef['t'][$v] = $fieldDef['chars'][$k];
    $fieldDef['c'][$v] = $fieldDef['colors'][$k];
    $fieldDef['s'][$v] = $fieldDef['classes'][$k];
    $fieldDef['f'][$v] = $fieldDef['fatype'][$k];
}
foreach ($fieldDef['t'] as $k => $v) {
?>
    <input name="item[<?php echo $fieldId ?>]" type="radio" value="<?php echo $k ?>" id="<?php echo $fieldId . $k ?>" />
    <label for="<?php echo $fieldId . $k ?>">
        <i class="fa<?= $fieldDef['f'][$k] ?> fa-<?= $fieldDef['t'][$k] . ' ' . $fieldDef['s'][$k] ?>" <?= (empty($fieldDef['c'][$k]) ? '' : ' style="color: ' . $fieldDef['c'][$k] . '"') ?>'></i>
    </label>
<?php } ?>