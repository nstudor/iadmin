# Security

## Built in

- **Authentication**: passwords are stored with `password_hash()` and checked with `password_verify()`
  (no md5). The session id is regenerated at login; logout destroys the session.
- **Authorization**: rights are checked on the server for every page and AJAX action, always from the database
  (see [Rights](rights.md)). `ajax/modal.php` requires a logged-in user.
- **CSRF**: each session has a token (`csrf_token()`), printed in `<meta name="csrf-token">`. `js/csrf.js` adds it
  to every POST form (field `_csrf`) and every jQuery AJAX request (header `X-CSRF-Token`).
  `index.php` rejects POSTs of logged-in users without it; `ajax/modal.php` and `script/export.php` reject any request
  without it. Forms submitted from inline scripts before the page is loaded must print the field themselves:
  `<input type="hidden" name="_csrf" value="<?= csrf_token() ?>">`.
- **SQL**: values are escaped with `db_esc()`; column names coming from requests are checked with `db_is_ident()`;
  add / edit only save the form's fields (`db_only()`); ids are escaped or cast.
- **Includes**: module names (`^[a-z0-9_]+$`), commands, AJAX action names and dashboard panel names are validated
  before being used in include paths.
- **Setup** runs only while `settings.ini` does not exist and writes it with `var_export()` (no code injection).

## Writing safe module code

- Use `db_esc()` for every value inside SQL strings and `db_is_ident()` for column names from user input:
  `db_select('*', $tabel, "code='" . db_esc($_GET['code']) . "'")`.
- Escape output that comes from users or the database: `htmlspecialchars($value, ENT_QUOTES)`.
- Check rights in special pages that change data: `has_right($rcr, 'modify_right')`.
- Values in `config.php` (`selectWhere`, `$defaultOrder`, `$tabel`) are used as written: never build them from requests.

## Deployment checklist

- Deny web access to everything that is not meant to be served, e.g. in `.htaccess`:
  ```apache
  <FilesMatch "^(settings\.ini|.*\.sql|.*\.md|error_log)$">
      Require all denied
  </FilesMatch>
  RedirectMatch 403 ^/(connector|settings|settings_default|script|vendor|docs|hidden|\.git|\.vscode)/
  ```
  (`ajax/`, `fieldtypes/`, `js/`, `css/`, `webfonts/`, `images/`, `template/` must stay reachable.)
- Keep `settings.ini` out of version control (it holds the database password): add `settings.ini` and `vendor/`
  to `.gitignore`.
- After installation, consider removing or protecting `setup/` (it refuses to run while `settings.ini` exists).
- Upload folders (`path` of fileUpload / imageUpload) must not execute PHP:
  ```apache
  # .htaccess in the upload folder
  php_flag engine off
  RemoveHandler .php .phtml
  ```
- Set `$DEBUG_MODE = false` in production.
- Never deploy development tools in the web root (web file editors, phpMyAdmin without extra protection, old copies).

## Not available yet

- **Password recovery**: the recover page exists in `login__pages`, but there is no handler (the old md5-token flow was
  removed). Administrators can set passwords in **Utilizatori**, row action **Parola**.
- Login rate limiting and an audit log.
