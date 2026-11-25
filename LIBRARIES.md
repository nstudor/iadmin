# Front-end libraries

Shared by all templates, loaded from the site root (`./css/...`, `./js/...`).
Copied from the npm package dists (jsDelivr). When updating, replace the files and the version below.

| Library | Version | npm package | Files |
|---|---|---|---|
| Bootstrap | 5.3.9 | `bootstrap` | `css/bootstrap.min.css`, `js/bootstrap.bundle.min.js` |
| Font Awesome Free | 6.7.2 | `@fortawesome/fontawesome-free` | `css/all.min.css`, `css/v4-shims.min.css`, `webfonts/*` |
| jQuery | 3.7.1 | `jquery` | `js/jquery.min.js` |
| Popper (UMD, global `Popper`, used by Tempus Dominus) | 2.11.8 | `@popperjs/core` | `js/popper.min.js` |
| BsMultiSelect | 1.1.18 | `@dashboardcode/bsmultiselect` | `js/BsMultiSelect.min.js`, `css/BsMultiSelect.min.css` |
| Tempus Dominus | 6.0.0-beta2 | `@eonasdan/tempus-dominus` | `js/tempus-dominus.js`, `js/jQuery-provider.js`, `css/tempus-dominus.css` |
| CKEditor | 4.10.1 | — | `js/ckeditor/` |
| bootstrap-colorpicker | 2.5.2 | `bootstrap-colorpicker` | `js/bootstrap-colorpicker.js`, `css/bootstrap-colorpicker.min.css` |

Own files:
- `css/colors.css` – 43 named colors (`bg-*`, `text-*`, `btn-*`, ...).
- `css/compat-bs4.css`, `js/compat-bs4.js` – Bootstrap 4 → 5 compatibility for markup still printed by
  field types, AJAX dialogs, settings pages and the login pages stored in `login__pages`
  (class aliases such as `float-left`, `sr-only`, `btn-block`, `input-group-append`; `data-toggle` → `data-bs-toggle`).
- `js/csrf.js` – adds the CSRF token to forms and jQuery AJAX requests.

Notes
- Font Awesome's CSS loads its fonts from `../webfonts/`: keep `webfonts/` next to `css/`.
- Font Awesome 6 keeps the v5 icon names as aliases; `v4-shims.min.css` adds the v4 names (`fa fa-pencil`).
- Load order: jQuery → `csrf.js` → `compat-bs4.js` → Popper → Bootstrap bundle → plugins.
