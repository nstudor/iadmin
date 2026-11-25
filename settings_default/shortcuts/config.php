<?php
// Shortcuts shown on the dashboard: two stacked Font Awesome icons (fa1 under fa2).
// Colors are class names from css/colors.css (text-<color>, bg-<color>, border-<color>, shadow-<color>).

$colors = [
    'navy' => 'Navy',
    'blue' => 'Blue',
    'aqua' => 'Aqua',
    'teal' => 'Teal',
    'olive' => 'Olive',
    'green' => 'Green',
    'lime' => 'Lime',
    'yellow' => 'Yellow',
    'orange' => 'Orange',
    'red' => 'Red',
    'fuchsia' => 'Fuchsia',
    'purple' => 'Purple',
    'maroon' => 'Maroon',
    'white' => 'White',
    'gray' => 'Gray',
    'silver' => 'Silver',
    'black' => 'Black',
    // blues / cyans
    'sky' => 'Sky',
    'cyan' => 'Cyan',
    'turquoise' => 'Turquoise',
    'steel' => 'Steel',
    'cobalt' => 'Cobalt',
    'royal' => 'Royal',
    // purples
    'indigo' => 'Indigo',
    'violet' => 'Violet',
    'lavender' => 'Lavender',
    'plum' => 'Plum',
    // pinks / reds
    'pink' => 'Pink',
    'rose' => 'Rose',
    'crimson' => 'Crimson',
    'coral' => 'Coral',
    'salmon' => 'Salmon',
    // yellows / browns
    'amber' => 'Amber',
    'gold' => 'Gold',
    'brown' => 'Brown',
    'tan' => 'Tan',
    'beige' => 'Beige',
    'cream' => 'Cream',
    // greens
    'emerald' => 'Emerald',
    'mint' => 'Mint',
    'forest' => 'Forest',
    // neutrals
    'slate' => 'Slate',
    'charcoal' => 'Charcoal',
];

$tabel = "login__shortcuts";
$fields = array(
    'id_user' => array(
        'name' => 'User',
        'type' => 'dbSelect',
        'table' => 'login__users',
        'field' => 'nume',
        'relatedField' => 'id',
        'defaultValue' => 0,
        'defaultResult' => '=ANY=',
    ),
    'id_role' => array(
        'name' => 'Role',
        'type' => 'dbSelect',
        'table' => 'login__roles',
        'field' => 'rolename',
        'relatedField' => 'id',
        'defaultValue' => 0,
        'defaultResult' => '=ANY=',
    ),
    'denumire' => "Denumire",
    'fa1' => "F1 Icon",
    'fa2' => "F2 Icon",

    'fa1type' => array(
        'name' => "FA1 type",
        'type' => 'text',
        'defaultValue' => 's',
    ),
    'fa2type' => array(
        'name' => "FA2 type",
        'type' => 'text',
        'defaultValue' => 's mx-3 my-2',
    ),
    'fa1color' => array(
        'name' => "FA1 color",
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'fa2color' => array(
        'name' => "FA2 color",
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'fa1shadow' => array(
        'name' => "FA1 shade",
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'fa2shadow' => array(
        'name' => "FA2 shade",
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'backcolor' => array(
        'name' => "Fundal",
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'textcolor' => array(
        'name' => "Text",
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'bordercolor' => array(
        'name' => "Border",
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'extraclass' => "Clasa extra",
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
