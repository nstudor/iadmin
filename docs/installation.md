# Installation

## Requirements

- PHP **8.1+** with `mysqli`, `mbstring`; `intl` recommended (localized month / day names), `gd` for image uploads.
- MySQL **5.7+** or MariaDB **10.3+**, an existing (empty) database and a user with rights on it.
- Apache with `mod_rewrite` (the `.htaccess` rewrites `*.htm` to `index.php?p=...`).
- For export (xls, xlsx, ods, csv, pdf): `composer install` (PhpSpreadsheet + mPDF) so that `vendor/` exists.

## Setup wizard

When `settings.ini` does not exist, `index.php` redirects to **`setup/`**. The wizard has three steps:

| Step | Fields |
|---|---|
| 1 Application | application name, template (folders in `template/`), language (`lang/*.lng.php`) |
| 2 Database | database type (`connector/*.con.php`), server, port, database name (must exist), user, password |
| 3 Administrator | user name (3-32: letters, digits, `. _ @ -`), full name, e-mail (used for password recovery), password (min. 6) + repeat |

On **Install** the wizard:

1. validates every field (errors are shown next to the field, the form keeps the values);
2. connects to the database;
3. checks for existing iAdmin tables — if there are any, it stops unless **Replace existing iAdmin tables**
   is ticked (this drops and recreates them: **their data is lost**);
4. imports [`setup/schema.sql`](../setup/schema.sql), replacing `[[USER]]`, `[[PASS]]` (a `password_hash()`),
   `[[NAME]]` and `[[EMAIL]]` with the SQL-escaped form values;
5. writes `settings.ini` — only after the database is ready.

If `settings.ini` cannot be written, the page shows its content so you can create it by hand.
When `settings.ini` exists the wizard refuses to run; delete it to install again.

## settings.ini

A PHP file included on every request:

```php
<?php
$APP_NAME = 'iAdmin';
$APP_TEMPLATE = 'Arachnania';      // folder in template/
$APP_LANGUAGE = 'english';         // lang/<name>.lng.php
$APP_DB_TYPE = 'mySQL';            // connector/<type>.con.php
$APP_DB_SERVER = 'localhost';
$APP_DB_NAME = 'iadmin';
$APP_DB_USER = 'iadmin';
$APP_DB_PASS = '...';
$APP_DB_PORT = '3306';
$DEBUG_MODE = false;               // true: show all PHP errors (development only)
// optional theme accents (class names, see templates.md):
// $tmpBackground = 'bg-gray'; $tmpText = 'text-white';
```

It contains the database password: keep it out of version control (add `settings.ini` to `.gitignore`) and make
sure the web server never serves it (see [Security](security.md#deployment-checklist)).

## Upgrading an existing database

Older installations used other table names and formats. Run what applies (MySQL / MariaDB):

```sql
-- 1. tables were renamed from login_* to login__*
RENAME TABLE login_agenda TO login__agenda, login_chat TO login__chat, login_dashboard TO login__dashboard,
  login_help TO login__help, login_menu TO login__menu, login_pages TO login__pages, login_rights TO login__rights,
  login_roles TO login__roles, login_shortcuts TO login__shortcuts, login_users TO login__users;

-- 2. menu links are module names now ("utilizatori", not "tabel-utilizatori")
UPDATE login__menu SET link = SUBSTRING(link, 7) WHERE link LIKE 'tabel-%';

-- 3. passwords are stored with password_hash(): the column needs 255 characters
ALTER TABLE login__users MODIFY `pass` varchar(255) NOT NULL DEFAULT '';

-- 4. the menu editor needs its own menu row + rights for role 1
INSERT INTO login__menu (id_tata, denum, link, ordine, `right`, icon) VALUES (1, 'Meniu', 'loginmenu', 60, 'N', 'sitemap');
INSERT INTO login__rights (id_menu, id_role, view_right, add_right, modify_right, delete_right)
  VALUES (LAST_INSERT_ID(), 1, 'Y', 'Y', 'Y', 'Y');
```

**Old md5 passwords no longer work** (only `password_verify()` is used). Set a new password for such accounts:
generate a hash on the server with `php -r 'echo password_hash("NewPassword", PASSWORD_DEFAULT);'` and

```sql
UPDATE login__users SET pass = '<the $2y$... value>' WHERE user = '<user name>';
```

Shortcuts with stacked icons need the columns from `setup/schema.sql` (`fa1`, `fa2`, `fa1type`, ... `extraclass`);
see [Database](database.md#login__shortcuts).
