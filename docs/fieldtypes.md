# Field types

`'type' => '<name>'` in a field definition. Each type has up to four views, dispatched by `fieldFormat()`:
`<type>.type.php` (list cell), `<type>_add.type.php`, `<type>_edit.type.php` (form inputs, posting
`item[<field>]`) and `<type>_filter.type.php` (filter dialog). A missing view shows "Modul neimplementat".

## text (default)

Plain text input.

| Option | Meaning |
|---|---|
| `modalEdit` | list: click the value to edit it in a modal |
| `modalSize` | size of that modal: `sm`, `lg` (default), `xl` |

## color

Text input with a color picker (`bootstrap-colorpicker`), list cell shows the color.

## awesomecase

A value from a short list shown as an icon (Y/N, on/off, states).

| Option | Meaning |
|---|---|
| `values` | values, array or comma separated: `'Y,N'` |
| `chars` | Font Awesome icon per value: `'check,times'` |
| `colors` | CSS color per value (optional) |
| `classes` | CSS classes per value: `'text-success,text-danger'` |
| `fatype` | Font Awesome style per value: `s` solid, `r` regular |
| `template` | preset for the options above, see below |
| `toggle` | list: click the icon to switch to the next value (needs modify right; saved through `mdoedit`, only the listed values are accepted) |
| `onclickchange` | list: name of a JS function called as `fn(this)` on click (icon has `data-field`, `data-value`, `data-id`) |

Presets (`fieldtypes/awesomecase/<name>.tpl.type.php`): `YesNoCheck`, `YesNoCircle`, `YesNoCircleCheck`,
`YesNoEye`, `YesNoEyeAlt`, `YesNoSquareCheck`, `YesNoSquareCheckAlt`, `YesNoStar`, `YesNoSwitch` (values `Y`/`N`)
and the same names with `Bool...` (values `1`/`0`).

## byteslength

Long text (textarea / rich text). The list shows the size (e.g. `12.4 Kb`) instead of the content.

| Option | Meaning |
|---|---|
| `mesaureUnit` | unit shown after the number, e.g. `'b'` |
| `unitSize` | multiplier, e.g. `1024` (default 1000) |
| `maxDepth` | 0 none, 1 up to K, 2 M, 3 G, 4 T |
| `prefix` / `suffix` | text around the value |
| `modalEdit` | list: click the size to edit the text in a modal |
| `modalSize` | modal size: `sm`, `lg` (default), `xl` |
| `richText` | use CKEditor |
| `textareaheight` | editor / textarea height in pixels |
| `fullpage` | the input takes the full form width |

## dbSelect

Select from another table.

| Option | Meaning |
|---|---|
| `table` | source table |
| `field` | column shown |
| `relatedField` | column stored (usually `id`) |
| `selectWhere` | SQL condition for the options (trusted config, not user input) |
| `defaultValue` / `defaultResult` | value and label of the "empty" option |

## enumSelect

Select from a fixed list.

| Option | Meaning |
|---|---|
| `selectFrom` | `value => label` |
| `defaultValue` / `defaultResult` | value and label of the "empty" option |

## formatDateTime

Date / time with a Tempus Dominus picker.

| Option | Meaning |
|---|---|
| `format` | display format: `date()` format (`'d.m.Y H:i'`, default) or `strftime`-style with `%` (`'%d %B %Y'`, localized) |
| `displayLocale` | locale for `%` formats, e.g. `'ro_RO.utf8'` |
| `nodate` | text shown for empty / zero dates (default `N/A`) |
| `locale` | picker language, e.g. `'ro'` |
| `sideBySide`, `calendar`, `clock`, `seconds`, `use24Hour` | picker options (`'true'` / `'false'`) |
| `iconSelect` | Font Awesome icon of the filter inputs |

The filter supports equal, different, greater / smaller and **between** (two dates).

## formatNumber

| Option | Meaning |
|---|---|
| `decimals` | decimals (default 2) |
| `decSep` / `thoSep` | decimal / thousands separator (default `.` / `,`) |
| `suffix` | text after the number |

## fileUpload / imageUpload

File input; the file is saved in `path` and the file name in the column.

| Option | Meaning |
|---|---|
| `path` | folder to save to (relative to the site root, with trailing `/`) |
| `buttonText` | upload button label |
| `filetype` | *imageUpload*: output format `jpg`, `png`, `gif`, `webp`, `wbmp` (the image is re-encoded) |
| `cropRatio` | *imageUpload*: crop to width / height ratio, e.g. `1.5` |
| `max` / `min` | *imageUpload*: limit the longer / shorter side in pixels |
| `plugin` | *imageUpload*: `array('name' => 'cloudinary', 'cloud' => ..., 'key' => ..., 'secret' => ..., 'path' => ...)` uploads to Cloudinary and removes the local file |

`fileUpload` keeps the original file name and does not restrict the extension: use it only for trusted users and
store uploads outside executable folders (see [Security](security.md#deployment-checklist)).

## Writing a field type

Create `fieldtypes/<name>.type.php` (+ `_add`, `_edit`, `_filter` as needed). Available variables:
`$fieldId` (column), `$fieldDef` (field options), `$fieldValue`, `$operation` (`_add`, `_edit`, `_filter` or
empty), `$pre` (path prefix to the site root), `$rowId` and `$uri` (row key and module, set in lists).
The current user's rights are in `$GLOBALS['rcr']`. Form inputs must be named `item[<field>]`; the inline editor
reads the input with `id="ajaxitem"`. Uploads: `<name>.process.php` receives `$fileName`, `$tempName`, `$k`, `$fields`
and sets `$MESSAGE` on error.
