# iAdmin documentation

iAdmin is a small PHP + MySQL admin framework: every database table becomes a **module** (a `config.php`
file describing the table and its fields) and gets a list page with filters, sorting, paging, add / edit /
delete forms, inline editing, bulk actions and export — with per-role rights, a dashboard and templates.

| Document | Contents |
|---|---|
| [Installation](installation.md) | requirements, setup wizard, `settings.ini`, upgrading an existing database |
| [Architecture](architecture.md) | request flow, URL scheme, folders, AJAX endpoints, dashboard |
| [Modules](modules.md) | writing a module: `config.php` variables, field flags, override files and hooks |
| [Field types](fieldtypes.md) | every field type and its options |
| [Rights](rights.md) | menu, roles, rights, special pages, how access is decided |
| [Templates](templates.md) | template contract, Badmannahy, Arachnania, Coatstrap, Bootstrap 4 compatibility, colors |
| [Security](security.md) | CSRF, passwords, SQL helpers, deployment checklist |
| [Developer reference](developer.md) | functions in `utils.php` and the database connector |
| [Database](database.md) | the `login__*` tables |
| [Libraries](libraries.md) | front-end libraries and their versions |

## Quick start

1. Copy the application to the web server (PHP 8.1+, MySQL 5.7+ / MariaDB 10.3+, an empty database).
2. Open the site: without `settings.ini` you are sent to `setup/`. Fill in the application, database and
   administrator steps and press **Install**.
3. Sign in with the administrator you created.
4. Add a module: create `settings/<module>/config.php` (see [Modules](modules.md)), add a menu entry
   with the menu editor (**Developer → Menu**) and give the role rights on it (**Setari → Profiluri → Rights**).

## Folder overview

```
index.php            entry point (all *.htm URLs are rewritten to index.php?p=...)
utils.php            shared helpers: rights, CSRF, passwords, field type dispatch, dates
settings.ini         installation settings (created by setup, PHP syntax)
connector/           database connector (mySQL.con.php)
setup/               setup wizard + schema.<language>.sql
script/              page controllers (list, add / edit / drop, dashboard)
ajax/                AJAX endpoints, all reached through ajax/modal.php
fieldtypes/          field types (display / add / edit / filter / upload processing)
settings_default/    built-in modules (users, roles, menu, dashboard, shortcuts, pages, login...)
settings/            your modules (override settings_default/ with the same name)
template/            templates: Badmannahy (top menu), Arachnania (sidebar, dark mode), Coatstrap (Bootstrap classes only)
lang/                translations (english.lng.php, romana.lng.php)
css/ js/ webfonts/   shared front-end libraries + colors.css, compat-bs4.*, csrf.js, fieldtypes.js
docs/                this documentation
```
