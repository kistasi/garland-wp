# Garland theme test environment

Docker stack for developing this theme. The repository root is bind-mounted
into the container as `wp-content/themes/garland`, so edits show up on reload —
no rebuild needed.

- Site: http://localhost:8080/ — admin: `admin` / `admin`
- WordPress 6.6, PHP 8.2, MariaDB 11, `WP_DEBUG` on (errors are displayed and
  logged to `wp-content/debug.log` inside the `wp` volume)

## Getting started

```sh
cd dev && ./setup.sh
```

Brings the stack up, installs WordPress, activates the theme, switches on
pretty permalinks and seeds the content. Re-running it is safe — the install
step is skipped once WordPress is installed, though `seed.sh` still resets the
content.

## Commands

```sh
docker compose up -d              # start
docker compose down               # stop
docker compose down -v            # stop and wipe DB + WP install
./seed.sh                         # reset content and re-seed (destructive)
docker compose run --rm cli <wp args>   # any wp-cli command, e.g. `plugin list`
docker compose logs -f wordpress  # PHP/Apache errors
```

## What `seed.sh` creates

Content covering every region the theme defines:

- Pages *About* and *Contact*; four posts, one sticky, one with threaded
  comments (three comments, one nested — exercises the zebra striping)
- Category `design` and tag `drupal` on the commented post
- Menus assigned to both `primary` and `secondary` nav locations
- Widgets in all six areas: `header`, `highlighted`, `help`, `sidebar-first`,
  `sidebar-second`, `footer`

## Pages worth checking

| URL | Template |
| --- | --- |
| `/` | `index.php` |
| `/post-with-comments/` | `single.php` + `comments.php` |
| `/about/` | `page.php` |
| `/category/design/` | `archive.php` |
| `/?s=garland` | `search.php` |
| `/definitely-not-here/` | `404.php` |

Colour scheme and fluid/fixed width live under **Appearance → Customize →
Garland Options**.
