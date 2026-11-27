# Architecture

## Request flow (`index.php`)

1. Start the session, load `utils.php`, `settings.ini` (missing → redirect to `setup/`), the language files
   (`lang/english.lng.php`, then `lang/<APP_LANGUAGE>.lng.php`) and the connector; connect to the database.
2. **CSRF**: every POST of a logged-in user must carry the session token (see [Security](security.md)).
3. **Login**: a POST with `log_user` / `log_pass` checks the user with `password_verify()`, regenerates the
   session id and stores `$_SESSION['userid']`.
4. **Route**: `?p=` is split on `-` into `$param`. No `?p=` → `home` (the dashboard). Logged-out users are
   always routed to the public `page` module (`page-<slug>`; `home` → `page-login`).
5. `$pag = $param[0]` (the module) must match `^[a-z0-9_]+$`, otherwise the 404 page is shown.
6. `script/index.scr.php` loads the user (`$ruser`), the module rights (`$rcr`, always from the database) and the menu.
7. The module config is included: `settings/<pag>/config.php`, else `settings_default/<pag>/config.php`.
8. Unless the config sets `$hasNoTable`:
   - rights are checked (`can_open_page()`): no right → **403** page;
   - the config must define `$tabel` and `$fields`, otherwise the **configuration error** page is shown;
   - `script/tabel.scr.php` runs the list or the command (add / edit / drop / special).
9. `template/<APP_TEMPLATE>/index.tpl.php` renders the layout and includes `<scriptPage>.tpl.php`
   (or the file named by `$scriptPage`, e.g. a module's special page).

## URL scheme

All URLs end in `.htm` and are rewritten to `index.php?p=<path>` (`.htaccess`). Parts are separated by `-`.

| URL | Page |
|---|---|
| `./` | home: dashboard panels (logged out: login page) |
| `<module>.htm` | list, page 1 |
| `<module>-<n>.htm` | list, page *n+1* (0-based) |
| `<module>-add.htm` | add form |
| `<module>-edit-id-<id>.htm` | edit form of row `<id>` |
| `<module>-drop-id-<id>.htm` | delete confirmation of row `<id>` |
| `<module>-<special>-id-<id>.htm` | special page `settings/<module>/<special>.php` for row `<id>` |
| `<module>-<n>-x-filtru-<column>-<value>.htm` | list filtered on `column = value` |
| `logout.htm` | logout |
| `page-<slug>.htm` (logged out: `<slug>.htm`) | public page from `login__pages` (`login`, `recover`, ...) |

Command names (`add`, `edit`, `drop`, specials) must be plain identifiers; `id` values are SQL-escaped.

## Folders

| Folder | Role |
|---|---|
| `script/` | `index.scr.php` (user, rights, menu), `tabel.scr.php` (list + command dispatch), `toper.add/edit/drop.scr.php` (save handlers), `dashboard.scr.php` + `dashboard/*.php` (panel data), `export.php` |
| `settings_default/` | built-in modules: `utilizatori` (users), `roluri` (roles + rights matrix), `loginmenu` (menu editor), `dashboard` (panel settings), `shortcuts`, `page` (public pages), `home`, `login`, `logout`, `ajax_actions/` |
| `settings/` | your modules; a folder with the same name as one in `settings_default/` replaces it |
| `fieldtypes/` | `<type>.type.php` (list cell), `<type>_add/_edit/_filter.type.php` (forms / filter dialog), `<type>.process.php` (upload processing) |
| `template/<name>/` | layout and page templates, see [Templates](templates.md) |

## AJAX endpoints

Every AJAX call goes through **`ajax/modal.php?p=<action>-<module>[-...]`**. It requires a logged-in user and the
CSRF token (header `X-CSRF-Token`, sent automatically by `js/csrf.js`), validates the module name, loads the
module rights and config, then includes the action.

| Action | URL / POST | Right needed | Purpose |
|---|---|---|---|
| `filter` | `filter-<mod>-<field>` | view | filter dialog of a column |
| `export` | `export-<mod>` | view | export dialog (posts to `script/export.php`) |
| `edit` | `edit-<mod>-<field>-<id>` | modify | edit one field in a modal (uploads, `modalEdit`) |
| `medit` | `medit-<mod>-<field>-<id>` | modify | inline editor (right click on a list cell) |
| `mdoedit` | `mdoedit-<mod>`, POST `id`, `field`, `item` | modify | save one field, returns the rendered cell |
| `multi` | `multi-<mod>-<op>-<idcol>`, POST `ids[]` | delete for `delete`/`dodelete`, else modify | bulk actions: `multi.<op>.php` |
| *custom* | `<action>-<mod>` | modify | `settings/ajax_actions/<action>.php`, else `settings_default/ajax_actions/<action>.php` |

`ajax/time.php` (clock) is called directly. Built-in custom actions: `ajaxright` / `ajaxdet` (rights matrix).

## Dashboard

The home page (`settings_default/home/config.php`) shows the panels of `login__dashboard` for the user
(`id_user` = user id, or `0` = everybody), grouped in rows by `rand`, sized by `marimesm` / `marimelg`
(Bootstrap columns on small / large screens), ordered by `ordine`, shown when `vizibil = 'Y'`, open when `deschis = 'Y'`.

A panel named `fisier = '<name>'` uses:
- `script/dashboard/<name>.php` — fills `$panelRows[...]['panels'][...]['data']` (runs once for all its panels);
- `template/<T>/dashboard-<name>.tpl.php` — renders one panel (`$panelData`).

Built-in panels: `calendar`, `agenda` (`login__agenda`, half-hour slots `$agenda['hour_start'..'hour_stop']`
in `settings_default/home/config.php`), `shortcuts` (`login__shortcuts`), `infoboxes`.
Panels are configured in the **Dashboard** module (`dashboard.htm`).

## Languages

`lang/<language>.lng.php` defines `$_LNG = ['key' => 'text', ...]`. `t('key')` returns the text of the
selected language, falls back to English, else `%%key%%`.

All interface texts outside `settings/` and `setup/` come from these files: templates, fieldtypes, AJAX dialogs,
messages and the `settings_default` modules (titles, column names). Add every new key to `lang/english.lng.php`
(the fallback) and translate it in the other files. Texts with values use `sprintf()` placeholders, e.g.
`sprintf(t('delete_rows_confirm'), $count)`. JavaScript texts reach the Arachnania / Coatstrap scripts through
`window.APP_LNG` (set in `index.tpl.php`).
