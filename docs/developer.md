# Developer reference

## Database connector (`connector/mySQL.con.php`)

Connection settings come from the `$APP_DB_*` globals (`settings.ini`). mysqli exceptions are off: functions return
`NULL` / `FALSE` and put the error in the global `$MESSAGE`.

| Function | Description |
|---|---|
| `db_connect()` | connect (charset `utf8mb4`); `FALSE` + `$MESSAGE` on error |
| `db_select($what, $table, $where = '1', $order = NULL, $limit = NULL, $keyField = NULL)` | rows as arrays (keyed by `$keyField` if given); `NULL` on error. `$what` may be an array of columns |
| `db_insert($what, $table)` | insert `column => value` (values escaped, column names checked); returns the new id or `FALSE` |
| `db_update($what, $table, $where)` | update `column => value` (values escaped, column names checked) |
| `db_drop($where, $table)` | `DELETE FROM $table WHERE $where` |
| `db_esc($value)` | escape a value for use inside quotes: `"name='" . db_esc($v) . "'"` |
| `db_is_ident($name)` | `true` if `$name` is a safe identifier (`[A-Za-z0-9_]+`) |
| `db_only($data, $allowed)` | keep only the keys of `$data` listed in `$allowed` |
| `db_tables()` | tables of the database |
| `db_schema_tables($sqlFile)` | tables created by a schema file |
| `db_initialize($sqlFile, $replace = [], $dropExisting = false)` | run a schema file, replacing `[[KEY]]` placeholders with escaped values (setup) |

`$where`, `$order` and `$limit` are raw SQL: build them only from trusted values or escaped input.

## utils.php

| Function | Description |
|---|---|
| `showMessage($msg, $type = 'success', $print = 0)` | Bootstrap alert HTML (`success`, `info`, `warning`, `danger`) |
| `t($key)` | translation (see [Architecture](architecture.md#languages)) |
| `fieldFormat($fieldId, $fieldDef, $fieldValue, $operation = '', $pre = '', $rowId = 0, $uri = '')` | render a field type view (`$operation`: '', `add`, `edit`, `filter`) |
| `awesomecase_def($fieldDef)` | resolve an awesomecase definition (preset + value maps) |
| `format_strftime($format, $timestamp = null, $locale = null)` | `strftime()` replacement (`%d %B %Y`, localized with intl) |
| `load_rights($module)` | rights of the logged-in user on a module (from the database) |
| `has_right($rights, $right)` | `true` if `$rights[$right] == 'Y'` |
| `can_open_page($rights, $param)` | page access rule (list / add / edit / drop / special) |
| `module_specials($module, $pre = '')` | `[$specials, $stitles]` of a module config |
| `csrf_token()` / `csrf_ok()` | session CSRF token / check the token of the request |
| `password_check($plain, $stored)` | `password_verify()` wrapper |
| `password_store($userId, $plain)` | save a new password hash; `false` + `$MESSAGE` if it could not be stored |
| `sendMail($array)` | `mail($array['to'], $array['subject'], $array['message'])` |
| `pr($x)` | debug print |

## Globals available in pages

| Variable | Content |
|---|---|
| `$param` | URL parts (`?p=` split on `-`) |
| `$pag` | module name |
| `$ruser` | logged-in user row |
| `$rcr` | rights of the user on the current module (`view_right` ... `details_v` arrays) |
| `$menu` | menu entries visible to the user |
| `$get` | `key => value` pairs from the URL after the command (`edit-id-5` → `['id' => 5]`) |
| `$item` | row loaded for edit / drop / special pages |
| `$MESSAGE` | last database error / message |

## JavaScript (shared)

| File | Provides |
|---|---|
| `js/csrf.js` | CSRF token on forms and jQuery AJAX |
| `js/compat-bs4.js` | Bootstrap 4 `data-*` attributes → Bootstrap 5 |
| `js/fieldtypes.js` | awesomecase `toggle` (`.ac-toggle` click → `mdoedit`) |

Template scripts provide `goModal()`, `postModal()`, `salveaza()`, `checkAll()` (see [Templates](templates.md#template-contract));
Arachnania also `appToast(message, type, delay)`.
