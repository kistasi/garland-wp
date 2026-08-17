# Garland for WordPress

A port of the classic Drupal Garland theme (`8.x-2.0-alpha3`, Drupal 9/10) to a
classic WordPress theme. The visual design, gradients, images and CSS are the
original ones; only the templating layer was rewritten.

## Installing

Copy this directory into `wp-content/themes/` (naming it `garland` is
conventional, since the text domain is `garland`) and activate it under
**Appearance → Themes**.

Then:

1. **Appearance → Menus** — assign menus to the *Primary menu* and *Secondary
   menu* locations.
2. **Appearance → Widgets** — fill the widget areas: Header, Highlighted, Help,
   Sidebar first, Sidebar second, Footer.
3. **Appearance → Customize → Garland Options** — pick the content width
   (fluid/fixed) and a colour scheme.

## How the Drupal theme maps over

| Drupal | WordPress |
| --- | --- |
| `garland.info.yml` regions `primary_menu` / `secondary_menu` | nav menu locations `primary` / `secondary` |
| regions `header`, `highlighted`, `help`, `sidebar_first`, `sidebar_second`, `footer` | widget areas of the same names |
| region `breadcrumb` | `garland_breadcrumb()` in `inc/template-tags.php` |
| region `title_tabs` (page-title block + local tasks) | page-title block markup in `single.php` / `page.php` / `index.php`; local tasks dropped (admin-only concept) |
| regions `page_top` / `page_bottom` | dropped; `wp_body_open()` / `wp_footer()` fill the same role |
| `garland.libraries.yml` | `garland_scripts()` in `functions.php` |
| `templates/page.html.twig` | `header.php` + `footer.php` (`#header`, `#container`, `#center`, `#content` and the sidebars are unchanged) |
| `templates/node.html.twig` | `template-parts/content.php`, `template-parts/content-page.php` |
| `templates/comment.html.twig` | `garland_comment()` + `comments.php` |
| `templates/block--system-branding-block.html.twig` | `garland_branding()` |
| `templates/maintenance-page.html.twig` | dropped; WordPress maintenance mode is core/plugin territory |
| `garland_preprocess_html()` (width + sidebar classes) | `garland_body_classes()` on `body_class` |
| `garland_preprocess_comment()` (zebra) | `garland_comment_classes()` on `comment_class` |
| `garland_preprocess_block()` / `_region()` (`.clearfix`, `.title`) | widget `before_widget` / `before_title` args |
| `theme-settings.php` (`garland_width`) | Customizer setting `garland_width` |
| `color/color.inc` | `inc/color-schemes.php` + Customizer setting `garland_color_scheme` |
| `node.html.twig` node classes | `garland_post_classes()` on `post_class` |

## Stylesheets

Enqueued in this order, matching `garland.libraries.yml`:

| File | Origin |
| --- | --- |
| `css/layout.css` | unchanged |
| `css/colors.css` | unchanged |
| `css/garland.css` | Drupal's `css/style.css`; only two broken image paths fixed |
| `css/wordpress.css` | new — utilities Drupal's base theme supplied (`clearfix`, `visually-hidden`), WordPress-class mappings, WP-required classes (alignments, captions, galleries, sticky), and a small-screen fallback |
| `css/print.css` | unchanged, `media="print"` |
| `css/style-rtl.css` | original RTL rules plus a new block covering the flexbox layout; loaded only on RTL locales |

`style.css` at the theme root carries the WordPress theme header only, so the
relative image paths inside `css/` stay valid.

## Colour schemes

All fifteen schemes from `color.inc` are available. Drupal's Color module
regenerated the theme's images and stylesheets on save; here the schemes are
applied as inline CSS, with the tints derived by blending the base colour toward
white using the same ratios the default stylesheet uses (verified to land within
one step of the original values).

One consequence: the small bitmap backgrounds (`bg-tab.png`,
`bg-navigation-item*.png`, the menu bullet GIFs) keep their original blue, since
there is no image-regeneration step. They are only visible on menu hover states.

## Intentionally not ported

- **Local tasks / tabs** (`menu-local-tasks.html.twig`) — Drupal's per-node admin
  tabs have no WordPress counterpart. The CSS for `ul.primary` / `ul.secondary`
  is still in `css/garland.css` if you want to reuse the look.
- **Maintenance page** — see the table above.
- Drupal-admin-only rules in `css/garland.css` (vertical tabs, dropbuttons,
  status report, admin panels) were left in place but match no WordPress markup.
