<?php

/**
 * Parameters
 * values : Values of the case / switch Ex: array('Y','N'); (or comma separated string : 'Y,N')
 * chars : FontAwesome chars to be replaced with Ex: array('check','times'); (or comma separated string : 'check,times')
 * colors : Colors of chars Ex: array('#94C11E','#D40000'); (or comma separated string : '#94C11E,#D40000')
 * classes : Classes of chars Ex: array('text-success','text-danger'); (or comma separated string : 'text-success,text-danger')
 * template : Predefined data for previous 4 parameters
 *      templates defined :
 *          YesNoCheck
 *          YesNoCircleCheck
 *          YesNoSquareCheck
 * fatype : Fontawesome type (s - Solid, r - reversed ,l - light *PRO)
 * toggle : true = in lists, click the icon to switch to the next value (needs modify right; saved through ajax/modal.php mdoedit)
 * onclickchange : name of a JS function called as fn(this) on click in lists (the icon has data-field, data-value, data-id)
 */
$fieldDef = awesomecase_def($fieldDef);
$val = (string)$fieldValue;
$attr = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES);

$classes = 'fa' . ($fieldDef['f'][$val] ?? '') . ' fa-' . ($fieldDef['t'][$val] ?? '') . ' ' . ($fieldDef['s'][$val] ?? '');
$extra = empty($fieldDef['c'][$val]) ? '' : ' style="color: ' . $attr($fieldDef['c'][$val]) . '"';

// list cell of an existing row: $uri = module, $rowId = row key
if ($uri != '' && (string)$rowId !== '' && (string)$rowId !== '0') {
    if (!empty($fieldDef['toggle']) && (($GLOBALS['rcr']['modify_right'] ?? '') == 'Y')) {
        $vals = array_values(array_map('strval', $fieldDef['values']));
        $pos = array_search($val, $vals, true);
        $next = $vals[$pos === false ? 0 : ($pos + 1) % count($vals)];
        $classes .= ' ac-toggle';
        $extra .= ' role="button" title="' . $attr(t('click_to_change')) . '" data-pag="' . $attr($uri) . '" data-field="' . $attr($fieldId) .
            '" data-id="' . $attr($rowId) . '" data-next="' . $attr($next) . '"';
    } elseif (!empty($fieldDef['onclickchange']) && preg_match('/^[A-Za-z_$][A-Za-z0-9_$.]*$/', $fieldDef['onclickchange'])) {
        $extra .= ' role="button" onclick="' . $fieldDef['onclickchange'] . '(this)" data-field="' . $attr($fieldId) .
            '" data-value="' . $attr($val) . '" data-id="' . $attr($rowId) . '"';
    }
}

echo '<i class="' . $attr(trim($classes)) . '"' . $extra . '></i>';
