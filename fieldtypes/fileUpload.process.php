<?php
    $size1 = filesize($tempName);
    file_put_contents($fields[$k]['path'].$fileName, file_get_contents($tempName));
    $size2 = filesize($fields[$k]['path'].$fileName);
    if($size1 != $size2) $MESSAGE = "Error saving file !";
?>