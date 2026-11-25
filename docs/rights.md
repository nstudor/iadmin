# Rights

Rights are stored in the database and **loaded on every request** (never cached in the session), so changes
apply immediately. Menu visibility is cached in the session (`$_SESSION['menudata']`) until the next login.

## Data

| Table | Meaning |
|---|---|
| `login__roles` | roles (`id`, `rolename`). Role 1 = "Developer - Full access" (also sees **Developer → Menu**) |
| `login__users.role` | the user's role |
| `login__menu` | menu tree (`id_tata` = parent, `0` = root), `link` = **module name**, `right = 'Y'` = visible to everybody |
| `login__rights` | per menu row and role: `view_right`, `add_right`, `modify_right`, `delete_right` (`Y`/`N`) and `details_v`, `details_a`, `details_m`, `details_d` (space separated special page names) |

Rights are edited in **Setari → Profiluri**, button **Rights** of a role: the four buttons toggle the rights,
**Extra** opens the special pages of the module.

## How access is decided

`load_rights($module)` finds the `login__menu` row whose `link` is the module and the `login__rights` row of that menu
row and the user's role. **No menu row or no rights row = no access.** A menu row with `right = 'Y'` gives view access.

| Page | Needs |
|---|---|
| list (`<module>.htm`) | `view_right` |
| add | `add_right` |
| edit, inline edit, awesomecase toggle | `modify_right` |
| delete, bulk delete | `delete_right` |
| special page `<module>-<special>-id-<id>` | `view_right` + special listed in `details_v`; posting its form also needs it in `details_m` |
| filter, export | `view_right` |
| other bulk actions, custom AJAX actions | `modify_right` |

Exceptions:
- **Own password**: every user may open `utilizatori-key-id-<own id>.htm` (Account → Change password).
  The old password is always required. Changing another user's password needs `modify_right` on `utilizatori`.
- Modules with `$hasNoTable` (home, public pages, logout) are not checked.

Denied pages show the 403 page; denied AJAX calls return HTTP 403.

## Adding a module for a role

1. **Developer → Menu**: add a row (parent, label, `link` = module name, order).
2. **Profiluri → Rights** of the role: switch on view / add / modify / delete; under **Extra** tick the special pages.
3. Users of that role see the menu entry after their next login.
