<?php

function showMessage($msg, $type = 'success', $print = 0, $icon = 1)
{

    if ($icon) {
        // TODO: SHOW ICON STUFF
    }

    $txt = '<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';

    if ($print) {
        echo $txt;
    }

    return $txt;

}

function pr($x)
{
    echo "<pre>";
    print_r($x);
    echo "</pre>";
}

function sendMail($mailArray) {
    mail($mailArray['to'], $mailArray['subject'], $mailArray['message']);
}

function fieldFormat($fieldId, $fieldDef, $fieldValue, $operation = '', $pre = '', $rowId = 0, $uri = '')
{
    $type = (empty($fieldDef['type']) ? 'text' : $fieldDef['type']);

    if (!empty($operation)) {
        $operation = "_$operation";
        if (empty($pre)) {
            $pre = '../';
        }
    }
    if (file_exists("{$pre}fieldtypes/$type$operation.type.php")) {
        include("{$pre}fieldtypes/$type$operation.type.php");
    } else {
        include("{$pre}ajax/404.php");
    }
}

function t($x) {
    global $_LNG, $_DEFLNG;
    return (isset($_LNG[$x])?$_LNG[$x]:(isset($_DEFLNG[$x])?$_DEFLNG[$x]:"%%$x%%"));
}

?>
