# Database

The framework tables are created by [`setup/schema.sql`](../setup/schema.sql) (InnoDB, `utf8mb4_unicode_ci`).
Your own module tables can have any name and structure; a module only needs a primary key (`$id`, default `id`).

## login__users

Users. `user` (unique login name), `pass` (`password_hash()`, `varchar(255)`), `nume` (full name), `role`
(→ `login__roles.id`), `email` (password recovery), `logtime` (last login) and contact / profile columns
(`telefon`, `mobil`, `functie`, `details`, ...).

## login__roles

`id`, `rolename`. Role 1 ("Developer - Full access") also gets the **Developer → Menu** entry.

## login__menu

Menu tree: `id`, `id_tata` (parent; `0` = top level; the row with id `0` is the ROOT and is never shown), `denum`
(label, `-` = divider), `link` (module name; empty for groups), `ordine` (order), `right` (`Y` = visible to everybody),
`icon` (Font Awesome name, used by Arachnania).

## login__rights

One row per menu row and role (`UNIQUE (id_menu, id_role)`): `view_right`, `add_right`, `modify_right`,
`delete_right` (`Y`/`N`), `details_v`, `details_a`, `details_m`, `details_d` (space separated special pages).
See [Rights](rights.md).

## login__pages

Public pages: `slug`, `title`, `content` (HTML), `public` (`Y` = page, `B` = block). Blocks: `index` wraps every
public page (`[[content]]`), `loginform` replaces `[LOGINFORM]`. Placeholders: `[sign_in_title]`, `[sign_in_username]`,
`[sign_in_password]`, `[sign_in_button]`, `[sign_in_recover]`, `[sign_in_message]`, `[recover_email]`, `[recover_button]`
(filled from the language file). Unknown slugs show the `login` page.

## login__dashboard

Dashboard panels: `id_user` (`0` = all users), `denumire` (title), `fisier` (panel name: `calendar`, `agenda`,
`shortcuts`, `infoboxes`), `rand` (row), `ordine`, `marimesm` / `marimelg` (width 1-12 on small / large screens),
`deschis` (open), `vizibil` (shown). See [Architecture](architecture.md#dashboard).

## login__shortcuts

Dashboard shortcuts: `id_user`, `id_role`, `denumire`, `link`, `newtab`, `public`, `ordine` and the icon:
`fa1` / `fa2` (two stacked Font Awesome icons), `fa1type` / `fa2type` (style: `s`, `r`, plus classes),
`fa1color`, `fa2color`, `fa1shadow`, `fa2shadow`, `backcolor`, `textcolor`, `bordercolor` (color names from
`colors.css`), `extraclass`. Rows with only a `fontawesome` column (older layout) are also displayed.

## login__agenda

Agenda entries: `id_user`, `data` (date), `ora` (half-hour slot: 16 = 08:00, 17 = 08:30, ...), `durata`
(number of slots), `subiect`, `descriere`.

## login__chat, login__help

Reserved (not used by the current code).
