<?php

$tabel = "login_shortcuts";
$fields = array(
    'id_user' => array(
        'name' => 'User',
        'type' => 'dbSelect',
        'table' => 'login_users',
        'field' => 'nume',
        'relatedField' => 'id',
        'defaultValue' => 0,
        'defaultResult' => '=ANY=',
    ),
    'id_role' => array(
        'name' => 'Role',
        'type' => 'dbSelect',
        'table' => 'login_roles',
        'field' => 'rolename',
        'relatedField' => 'id',
        'defaultValue' => 0,
        'defaultResult' => '=ANY=',
    ),
    'denumire' => "Denumire",
    'fontawesome' => "Font Awesome",
    'backcolor' => array(
        'name' => "Fundal",
        'type' => 'color',
    ),
    'textcolor' => array(
        'name' => "Text",
        'type' => 'color',
    ),
    'bordercolor' => array(
        'name' => "Border",
        'type' => 'color',
    ),
    'link' => "Link",
    'newtab' => array(
        'name' => 'New Tab',
        'type' => 'awesomecase',
        'template' => 'YesNoSquareCheck',
        'fatype' => 'r,r'
    ),
    'ordine' => "Order",
    'public' => array(
        'name' => 'Public',
        'type' => 'awesomecase',
        'template' => 'YesNoSquareCheck',
        'fatype' => 'r,r'
    ),
);

$order = "";
$title = "Scurtaturi";
?>