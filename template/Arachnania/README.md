# Arachnania template

Modern sidebar admin layout for iAdmin: Bootstrap 5.3 + Font Awesome 6, light / dark mode,
responsive lists with a sticky header, toast messages and a centered sign-in page.

## Activate

In `settings.ini`:

```php
$APP_TEMPLATE="Arachnania";
```

(or choose **Arachnania** in `setup/`). Optional accents from `settings.ini` are still used:
`$tmpBackground` / `$tmpText` (table header, modal header).

## Libraries

Loaded from the shared `css/` and `js/` folders (versions in `docs/libraries.md`):
Bootstrap 5.3, Font Awesome 6 (+ v4 shims), jQuery 3.7, Popper 2 (global for Tempus Dominus), BsMultiSelect 1.x.

Also loaded from the app root because shared code depends on their APIs:
`js/tempus-dominus.js` + `js/jQuery-provider.js` (beta2 API used by the date fieldtypes),
`js/ckeditor/`, `js/bootstrap-colorpicker.js`, `js/csrf.js`, `css/colors.css`, `css/tempus-dominus.css`.

## Bootstrap 4 compatibility

Field types, AJAX dialogs, settings pages and the login pages stored in `login__pages` still print
Bootstrap 4 markup. `css/compat-bs4.css` aliases the old classes (`float-left/right`, `ml/mr-*`,
`sr-only`, `btn-block`, `input-group-append`, `col-xs-*`, `.close`, glyphicons...) and
`js/compat-bs4.js` copies `data-toggle/target/dismiss` to `data-bs-*` (also for HTML loaded later).

## Files

- `index.tpl.php` – layout: sidebar app shell (logged in) or sign-in layout (public pages);
  holds the shared `#filterModal`, `#contextMenu` and toast container.
- `arachnania.js` – sidebar, theme toggle, clock, toasts (`appToast(msg, type)`),
  `goModal()`, `postModal()`, `salveaza()`, `checkAll()`.
- page templates: `tabel`, `toper.add/edit/drop`, `dashboard` (+ panels), `page`, `logout`,
  `403`, `404`, `configerror`, `recover`, `none`.
