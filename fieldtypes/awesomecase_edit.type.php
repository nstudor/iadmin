<?php
if (!empty($fieldDef['template'])) include('awesomecase/' . $fieldDef['template'] . '.tpl.type.php');

if (!is_array($fieldDef['values'] ?? null)) $fieldDef['values'] = explode(',', $fieldDef['values'] ?? '');
if (!is_array($fieldDef['chars'] ?? null)) $fieldDef['chars'] = explode(',', $fieldDef['chars'] ?? '');
if (!is_array($fieldDef['colors'] ?? null)) $fieldDef['colors'] = explode(',', $fieldDef['colors'] ?? '');
if (!is_array($fieldDef['classes'] ?? null)) $fieldDef['classes'] = explode(',', $fieldDef['classes'] ?? '');
if (!is_array($fieldDef['fatype'] ?? null)) $fieldDef['fatype'] = explode(',', $fieldDef['fatype'] ?? '');

foreach ($fieldDef['values'] as $k => $v) {
    $fieldDef['t'][$v] = $fieldDef['chars'][$k] ?? '';
    $fieldDef['c'][$v] = $fieldDef['colors'][$k] ?? '';
    $fieldDef['s'][$v] = $fieldDef['classes'][$k] ?? '';
    $fieldDef['f'][$v] = $fieldDef['fatype'][$k] ?? '';
}
?>
<input type="hidden" id="ajaxitem" value="<?= htmlspecialchars((string)$fieldValue) ?>">
<?php foreach ($fieldDef['t'] as $k => $v) {
?>
    <input name="item[<?= $fieldId ?>]" type="radio" value="<?= $k ?>" <?php if ($k == $fieldValue) echo " checked" ?> id="<?= $fieldId . $k ?>" onclick="$('#ajaxitem').val('<?= $k ?>')" />
    <label for="<?= $fieldId . $k ?>">
        <i class="fa<?= $fieldDef['f'][$k] ?> fa-<?= $fieldDef['t'][$k] . ' ' . $fieldDef['s'][$k] ?>" <?= (empty($fieldDef['c'][$k]) ? '' : ' style="color: ' . $fieldDef['c'][$k] . '"') ?>></i>
    </label>
<?php } ?>