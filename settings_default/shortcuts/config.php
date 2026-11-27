<?php
// Shortcuts shown on the dashboard: two stacked Font Awesome icons (fa1 under fa2).
// Colors are class names from css/colors.css (text-<color>, bg-<color>, border-<color>, shadow-<color>).

$colors = [
    'navy' => t('color_navy'),
    'blue' => t('color_blue'),
    'aqua' => t('color_aqua'),
    'teal' => t('color_teal'),
    'olive' => t('color_olive'),
    'green' => t('color_green'),
    'lime' => t('color_lime'),
    'yellow' => t('color_yellow'),
    'orange' => t('color_orange'),
    'red' => t('color_red'),
    'fuchsia' => t('color_fuchsia'),
    'purple' => t('color_purple'),
    'maroon' => t('color_maroon'),
    'white' => t('color_white'),
    'gray' => t('color_gray'),
    'silver' => t('color_silver'),
    'black' => t('color_black'),
    // blues / cyans
    'sky' => t('color_sky'),
    'cyan' => t('color_cyan'),
    'turquoise' => t('color_turquoise'),
    'steel' => t('color_steel'),
    'cobalt' => t('color_cobalt'),
    'royal' => t('color_royal'),
    // purples
    'indigo' => t('color_indigo'),
    'violet' => t('color_violet'),
    'lavender' => t('color_lavender'),
    'plum' => t('color_plum'),
    // pinks / reds
    'pink' => t('color_pink'),
    'rose' => t('color_rose'),
    'crimson' => t('color_crimson'),
    'coral' => t('color_coral'),
    'salmon' => t('color_salmon'),
    // yellows / browns
    'amber' => t('color_amber'),
    'gold' => t('color_gold'),
    'brown' => t('color_brown'),
    'tan' => t('color_tan'),
    'beige' => t('color_beige'),
    'cream' => t('color_cream'),
    // greens
    'emerald' => t('color_emerald'),
    'mint' => t('color_mint'),
    'forest' => t('color_forest'),
    // neutrals
    'slate' => t('color_slate'),
    'charcoal' => t('color_charcoal'),
];

$tabel = "login__shortcuts";
$fields = array(
    'id_user' => array(
        'name' => t('fld_user'),
        'type' => 'dbSelect',
        'table' => 'login__users',
        'field' => 'nume',
        'relatedField' => 'id',
        'defaultValue' => 0,
        'defaultResult' => t('any'),
    ),
    'id_role' => array(
        'name' => t('fld_role'),
        'type' => 'dbSelect',
        'table' => 'login__roles',
        'field' => 'rolename',
        'relatedField' => 'id',
        'defaultValue' => 0,
        'defaultResult' => t('any'),
    ),
    'denumire' => t('fld_name'),
    'fa1' => t('fld_fa1_icon'),
    'fa2' => t('fld_fa2_icon'),

    'fa1type' => array(
        'name' => t('fld_fa1_type'),
        'type' => 'text',
        'defaultValue' => 's',
    ),
    'fa2type' => array(
        'name' => t('fld_fa2_type'),
        'type' => 'text',
        'defaultValue' => 's mx-3 my-2',
    ),
    'fa1color' => array(
        'name' => t('fld_fa1_color'),
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'fa2color' => array(
        'name' => t('fld_fa2_color'),
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'fa1shadow' => array(
        'name' => t('fld_fa1_shade'),
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'fa2shadow' => array(
        'name' => t('fld_fa2_shade'),
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'backcolor' => array(
        'name' => t('fld_background'),
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'textcolor' => array(
        'name' => t('fld_text'),
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'bordercolor' => array(
        'name' => t('fld_border'),
        'type' => 'enumSelect',
        'selectFrom' => $colors,
    ),
    'extraclass' => t('fld_extra_class'),
    'link' => t('fld_link'),
    'newtab' => array(
        'name' => t('fld_new_tab'),
        'type' => 'awesomecase',
        'template' => 'YesNoSquareCheck',
        'fatype' => 'r,r'
    ),
    'ordine' => t('fld_order'),
    'public' => array(
        'name' => t('fld_public'),
        'type' => 'awesomecase',
        'template' => 'YesNoSquareCheck',
        'fatype' => 'r,r'
    ),
);

$order = "";
$title = t('title_shortcuts');
