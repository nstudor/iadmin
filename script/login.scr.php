<?php
if (in_array($param[1], ['recover','newpass'])) {
    $param2 = $param;
    $param = [$param[1]];

    if (file_exists('script/' . $param[0] . '.scr.php')) {
        include('script/' . $param[0] . '.scr.php');
    }
}

