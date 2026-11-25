# Modules

A module is a folder `settings/<module>/` (module names: `a-z`, `0-9`, `_`) with a `config.php` that
describes one table. `settings/<module>/` replaces a built-in `settings_default/<module>/` with the same name.

To make a module reachable: add a menu row with `link = '<module>'` (menu editor, **Developer → Menu**) and
give the roles rights on it (**Profiluri → Rights**). Without a menu row and rights the module returns 403
— see [Rights](rights.md).

## Example

```php
<?php
// settings/products/config.php
$tabel = "products";                 // table name
$title = "Products";                 // page title
$id = "id";                          // primary key column (default "id")
$fields = array(
    'id'    => array('name' => 'ID', 'noAdd' => 1, 'noEdit' => 1),
    'name'  => "Name",                // plain text field: just the label
    'price' => array('name' => 'Price', 'type' => 'formatNumber', 'decimals' => 2, 'suffix' => ' lei'),
    'category' => array(
        'name' => 'Category', 'type' => 'dbSelect',
        'table' => 'categories', 'field' => 'name', 'relatedField' => 'id',
        'defaultValue' => 0, 'defaultResult' => '- none -',
    ),
    'active' => array('name' => 'Active', 'type' => 'awesomecase', 'template' => 'YesNoSquareCheck', 'toggle' => true),
    'created' => array('name' => 'Created', 'type' => 'formatDateTime', 'format' => 'd.m.Y', 'noAdd' => 1),
    'notes' => array('name' => 'Notes', 'type' => 'byteslength', 'richText' => 1, 'modalEdit' => 1, 'noShow' => 1),
);
$specials = array('history');        // settings/products/history.php, opened as products-history-id-<id>.htm
$stitles = array('history' => 'History');
$fontawesome = array('history' => 'clock-rotate-left');
$exportTo = array('xlsx', 'csv', 'pdf');
```

## config.php variables

| Variable | Meaning |
|---|---|
| `$tabel` | **required** table name |
| `$fields` | **required** `column => label` or `column => array(options)` (see below), in display order |
| `$title` | page title (default: module name) |
| `$id` | primary key column (default `id`) |
| `$defaultOrder` | SQL `ORDER BY` used instead of the user's sort, e.g. `"name ASC"` |
| `$specials` | special pages of a row (see below) |
| `$stitles` | `special => label` |
| `$fontawesome` | `special => icon` (Font Awesome name without `fa-`, extra classes allowed: `'eye text-green'`) |
| `$inlineSpecials` | `special => button class` — specials shown as buttons in an extra column (e.g. `'outline-secondary'` → `btn-outline-secondary`) |
| `$multiOper` | bulk actions on checked rows: `op => label`, handled by `multi.<op>.php` (see hooks) |
| `$exportTo` | export formats: any of `xls`, `xlsx`, `ods`, `csv`, `pdf` (needs `vendor/`, see [Installation](installation.md)) |
| `$showFilter = 'no'` | hide the filter icons |
| `$showOrder = 'no'` | hide the sort icons |
| `$dontshowpages = 1` | no paging (all rows) |
| `$noDropConfirm = 1` | delete without the confirmation page |
| `$hasNoTable = 1` | the module is not a table list; `$scriptPage` names the template (e.g. `page`, `dashboard`). No rights check. |
| `$scriptPage` | template to render (normally set by the framework) |

## Field options

Every field array may use:

| Option | Meaning |
|---|---|
| `name` | column label |
| `type` | field type (default `text`), see [Field types](fieldtypes.md) |
| `noShow` | not shown in the list (still in forms) |
| `noAdd` | not in the add form (and not saved on add) |
| `noEdit` | not in the edit form, not editable inline, not saved on edit |
| `noDel` | not shown on the delete confirmation |

Only fields of the add / edit form are saved: posted columns that are not in `$fields` (or are `noAdd` / `noEdit`) are ignored.

## Override files and hooks

All optional, placed in the module folder. Where noted, `settings_default/<module>/` is used as a fallback.

| File | Used for |
|---|---|
| `<field>_show.php` | list cell (and delete confirmation, with fallback) instead of the field type; row in `$r`, field definition in `$v` |
| `<field>_add.php` / `<field>_edit.php` | form input instead of the field type (fallback). Must post `item[<field>]` |
| `<field>_filter.php` | filter dialog instead of the field type |
| `<field>_medit.php` | runs in the field's edit modal (`ajax/edit.php`); may set `$extra` = HTML shown next to the Ok button (fallback) |
| `header.php` | replaces the list title (e.g. buttons, extra filters) |
| `line.php` | runs for every list row: set `$rowClass` (row CSS class, e.g. `'table-red'`) and `$cellClass['<field>']` |
| `bottom.php` | printed under the list |
| `add.php` | runs after a successful insert; `$id` = new row id (fallback) |
| `new.php` | if present, after an insert the user is sent to `<module>-new-<id>.htm` instead of the list |
| `<special>.php` | a special page: `<module>-<special>-id-<id>.htm`; the row is in `$item`, rights in `$rcr` |
| `multi.<op>.php` | bulk action `<op>` from `$multiOper`: `$ids` = checked row ids, `$pp` = URL parts. Looked up in `ajax/`, then the module folder |

Built-in bulk actions in `ajax/`: `multi.delete.php` (confirmation) → `multi.dodelete.php` (deletes `$ids`).

## Filters

The filter icon of a column opens the field type's filter dialog. Filters are kept in the session per module
(`$_SESSION['filter']`, `$_SESSION['filtertype']`). Filter types (`fv`):

| fv | Condition | fv | Condition |
|---|---|---|---|
| 1 | `LIKE '%v%'` | 8 | between (`a~b`) |
| 2 | `NOT LIKE '%v%'` | 9 | `LIKE 'v'` (own wildcards) |
| 3 | `= v` | 11 / 12 | `> v` / `< v` |
| 4 | `!= v` | 13 / 14 | `>= v` / `<= v` |
| 5 | remove this filter | 999 | remove all filters |
| 6 | `IN (values)` (checkbox lists) | | |

Column names must be plain identifiers and values are SQL-escaped.

## Custom AJAX actions

Put `<action>.php` in `settings/ajax_actions/` and call `ajax/modal.php?p=<action>-<module>`. The module
config is loaded and the user needs **modify** right on the module. See [Architecture](architecture.md#ajax-endpoints).
