# Templates

The template is chosen with `$APP_TEMPLATE` in `settings.ini` (folder in `template/`).

| Template | Description |
|---|---|
| **Badmannahy** | top navigation bar (3-level dropdown menu), bottom bar with account menu and clock |
| **Arachnania** | sidebar admin layout: collapsible 3-level menu (off-canvas on phones), top bar with clock, dark mode toggle and account menu; responsive lists with sticky header; toast messages; centered sign-in page |

Both use Bootstrap 5.3 and Font Awesome 6 from the shared `css/` and `js/` folders (see [Libraries](libraries.md)).

## Template contract

`index.php` includes `template/<T>/index.tpl.php`, which must:

1. include `<scriptPage>.head.php` (if present) inside `<head>`;
2. include `template/<T>/<scriptPage>.tpl.php`, or `$scriptPage` itself when it is a file path (special pages);
3. load jQuery, `js/csrf.js`, `js/fieldtypes.js`, `js/compat-bs4.js`, Popper, the Bootstrap bundle, Tempus Dominus
   (+ `jQuery-provider.js`), CKEditor, bootstrap-colorpicker, BsMultiSelect and `css/compat-bs4.css`, `css/colors.css`;
4. output `<meta name="csrf-token" content="<?= csrf_token() ?>">` for logged-in users;
5. provide what shared code uses:
   - `goModal(url, title, size)` / `postModal(url, title, data, size)` loading `ajax/modal.php?p=...` into `#filterModal`
     (`#filterModalTitle`, `.modal-dialog`, `.modal-body`);
   - `#contextMenu` (`.panel-info`, `.panel-data`, `.panel-submit`) + `salveaza()` for inline editing
     (right click on `td.cell`, saved with `mdoedit`);
   - `checkAll(checked)` for the row checkboxes (`.chboxoper`);
   - `#clock` filled from `ajax/time.php`;
   - `$('.color-selector').colorpicker()`;
   - the checkbox style `input[type=checkbox] + label` (Font Awesome icons).

Page templates: `tabel` (list), `toper.add`, `toper.edit`, `toper.drop`, `dashboard` + `dashboard-<panel>`,
`page` (public pages), `logout`, `403`, `404`, `configerror`, `recover` (+ `recover.htm`, the e-mail body), `none`.

Template variables: `$menu`, `$ruser`, `$rcr`, `$pag`, `$param`, `$fields`, `$rows`, `$st` / `$np` (current / last page),
`$title`, `$specials`, `$stitles`, `$fontawesome`, `$inlineSpecials`, `$multiOper`, `$exportTo`, `$MESSAGE`,
`$item`, `$addfields`, `$editfields`, `$dropfields`, `$id`, `$panelRows` / `$panelData`, `$APP_NAME`,
`$tmpBackground`, `$tmpText`.

## Theme accents

`$tmpBackground` and `$tmpText` (class names, default `bg-gray` / `text-white`, overridable in `settings.ini`) color
the table header, modal header and Badmannahy's bars. Any class from `colors.css` can be used.

Arachnania's own colors are CSS variables in `template/Arachnania/arachnania.css` (`--ar-accent`, `--ar-sidebar-bg`, ...).
Its dark mode uses Bootstrap's `data-bs-theme` (saved in the browser, default: the OS preference).

## Bootstrap 4 compatibility

Field types, AJAX dialogs, settings pages and the public pages stored in `login__pages` still contain Bootstrap 4
markup. `css/compat-bs4.css` maps the old classes (`float-left/right`, `ml-/mr-/pl-/pr-*`, `text-left/right`,
`font-weight-*`, `sr-only`, `btn-block`, `col-xs-*`, `input-group-append/prepend`, `.close`, `embed-responsive`,
glyphicons) and `js/compat-bs4.js` copies `data-toggle/target/dismiss` to `data-bs-*`, also for HTML loaded later.
New markup should use Bootstrap 5 directly.

## colors.css

47 named colors: navy, blue, aqua, teal, olive, green, lime, yellow, orange, red, fuchsia, purple, maroon, white,
gray, silver, black, sky, cyan, turquoise, steel, cobalt, royal, indigo, violet, lavender, plum, pink, rose,
crimson, coral, salmon, amber, gold, brown, tan, beige, cream, emerald, mint, forest, slate, charcoal,
storm-gray, burned-eggplant, river, lilac.

For every color `<c>`:

| Class | Effect |
|---|---|
| `bg-<c>`, `bkg-<c>` | background (links inside get a hover background) |
| `bg-<c>-subtle` | light tint |
| `text-<c>`, `txt-<c>` | text color (the first 17 also as `.<c>`) |
| `border-<c>`, `shadow-<c>` | border color, text shadow |
| `alert-<c>` | semi-transparent background |
| `btn-<c>`, `btn-outline-<c>`, `badge-<c>` | buttons and badges (readable text color computed per color) |
| `table-<c>` | row / cell tint (use in `line.php`: `$rowClass = 'table-red';`) |

Colors are CSS variables and can be overridden: `:root { --c-navy: #123456; }` (also `--c-<c>-rgb`,
`--c-<c>-hover`, `--c-<c>-fg`).
