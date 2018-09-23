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
*/

    if(!empty($fieldDef['template'])) include('awesomecase/'.$fieldDef['template'].'.tpl.type.php');
    
    if(!is_array($fieldDef['values'])) $fieldDef['values'] = explode(',', $fieldDef['values']);
    if(!is_array($fieldDef['chars'])) $fieldDef['chars'] = explode(',', $fieldDef['chars']);
    if(!is_array($fieldDef['colors'])) $fieldDef['colors'] = explode(',', $fieldDef['colors']);
    if(!is_array($fieldDef['classes'])) $fieldDef['classes'] = explode(',', $fieldDef['classes']);
    if(!is_array($fieldDef['fatype'])) $fieldDef['fatype'] = explode(',', $fieldDef['fatype']);
        
    foreach($fieldDef['values'] as $k=>$v) {
        $fieldDef['t'][$v]=$fieldDef['chars'][$k];
        $fieldDef['c'][$v]=$fieldDef['colors'][$k];
        $fieldDef['s'][$v]=$fieldDef['classes'][$k];
        $fieldDef['f'][$v]=$fieldDef['fatype'][$k];
    }
    
    echo '<i class="fa'.$fieldDef['f'][$fieldValue].' fa-'.$fieldDef['t'][$fieldValue].' '.$fieldDef['s'][$fieldValue].'" '.
            (empty($fieldDef['c'][$fieldValue])?'':' style="color: '.$fieldDef['c'][$fieldValue].'"').
            '></i>';
?>