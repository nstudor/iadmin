<?php

    $shortcuts=db_select('*', 'login_shortcuts', "(id_user=$ruser[id] OR id_role=$ruser[role]) AND public='Y'", 'ordine');
