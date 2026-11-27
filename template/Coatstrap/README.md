# Coatstrap template

Sidebar admin layout for iAdmin built **only with Bootstrap 5.3 classes**: the template has no stylesheet,
no `<style>` blocks and no `style=""` attributes. Every look comes from Bootstrap components and utilities
(`offcanvas-lg`, grid, `nav-pills`, `card`, `list-group`, `toast`, `collapse`, spacing / color / flex utilities).
Light / dark mode uses Bootstrap's own `data-bs-theme`.

## Activate

In `settings.ini`:

```php
$APP_TEMPLATE="Coatstrap";
```

(or choose **Coatstrap** in `setup/`).

## Colors

Coatstrap's own pages use only Bootstrap color classes. `css/colors.css` is still loaded for custom content:
`settings/*` pages, field definitions, `line.php` row classes and the dashboard shortcut colors (stacked icons), which are
written as colors.css names.

## Layout

- **Logged in:** sidebar with the 3-level menu (`collapse` submenus). It sits in the page from `lg` up and is an
  off-canvas panel on smaller screens. The sticky top bar holds the menu button, page title, clock,
  light / dark toggle and the account dropdown.
- **Public pages** (login, recover, `login__pages`): centered card on a `bg-body-tertiary` page.

## Stylesheets that are still loaded

Coatstrap adds no CSS of its own. `index.tpl.php` still loads the shared CSS that other code needs:

- `css/bootstrap.min.css`: the design layer.
- `css/all.min.css` + `v4-shims.min.css`: Font Awesome icons.
- `css/tempus-dominus.css`, `css/BsMultiSelect.min.css`, `css/bootstrap-colorpicker.min.css`: styles for the
  date picker, multiselect and color picker widgets used by the fieldtypes.
- `css/compat-bs4.css`: maps the Bootstrap 4 classes still printed by fieldtypes, AJAX dialogs and settings
  (see `docs/templates.md`).
- `css/colors.css`: color classes used by custom content (see Colors).

## Differences from Arachnania

- Checkboxes and radios are native (`form-check-input` in the lists). The Font Awesome
  `input[type=checkbox] + label` style from the other templates needs custom CSS, so it is not used.
  Fieldtype radios and checkboxes still work but show the browser control next to their label.
- The list header does not stick while scrolling, and the sidebar cannot be collapsed to icons on desktop.
  Both would need custom CSS.
- Dashboard panels open and close with Bootstrap `collapse`, and the state is still saved with `mdoedit-dashboard`.
- The inline cell editor (`#contextMenu`) is a `card position-fixed`. Only its position at the mouse pointer
  is set from JavaScript, because no class can express it.
- Single-icon shortcuts keep their inline `background-color / border-color / color` because those values are
  free CSS colors stored in the database.

## Files

- `index.tpl.php`: layout with the sidebar app shell (logged in) or the sign-in layout (public pages).
  It also holds the shared `#filterModal`, `#contextMenu` and the toast container.
- `coatstrap.js`: theme toggle, clock, toasts (`appToast(msg, type)`), sidebar chevrons, `goModal()`, `postModal()`,
  `salveaza()`, `checkAll()`.
- Page templates: `tabel`, `toper.add/edit/drop`, `dashboard` (+ panels), `page`, `logout`,
  `403`, `404`, `configerror`, `recover`, `none`.
