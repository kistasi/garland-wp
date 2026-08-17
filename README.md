# Garland for WordPress

A port of the classic Drupal Garland theme (`8.x-2.0-alpha3`, Drupal 9/10) to a
classic WordPress theme. The visual design is the original one; the templating
layer and the stylesheets have both been rewritten.

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
| region `breadcrumb` | `garland_get_breadcrumb()` in `inc/template-tags.php` |
| region `title_tabs` (page-title block + local tasks) | `garland_page_title()`, called by `single.php` / `page.php` / `index.php` / `404.php`; local tasks dropped (admin-only concept) |
| regions `page_top` / `page_bottom` | dropped; `wp_body_open()` / `wp_footer()` fill the same role |
| `garland.libraries.yml` | `garland_scripts()` in `functions.php` |
| `templates/page.html.twig` | `header.php` + `footer.php` (`#header`, `#container`, `#center`, `#content` and the sidebars keep their IDs; `#header` spans the window and `.header-inner` holds the content) |
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

| File | Contents |
| --- | --- |
| `css/layout.css` | metric tokens, the flexbox page frame, the small-screen breakpoint |
| `css/colors.css` | the design tokens — colours and the inline SVG assets — and the surfaces painted from them |
| `css/garland.css` | general element styling, from Drupal's `css/style.css` |
| `css/wordpress.css` | utilities Drupal's base theme supplied (`clearfix`, `visually-hidden`), WordPress-class mappings, and WP-required classes (alignments, captions, galleries, sticky) |
| `css/print.css` | print styles, `media="print"` |
| `css/style-rtl.css` | RTL overrides; loaded only on RTL locales |

`style.css` at the theme root carries the WordPress theme header only.

Three conventions hold across all of them:

- **No bitmaps.** The theme ships no `images/` directory. The header,
  breadcrumb, tab and panel gradients are CSS gradients; the pointer above the
  active primary-menu item is a `clip-path` triangle; the list markers and the
  disclosure caret are inline SVG data URIs declared next to the colour tokens.
  The only files left are `logo.svg` and WordPress's own `screenshot.png`.
- **No literal colours outside `css/colors.css`.** Everything else reads a
  `--garland-*` custom property, which is what makes the colour schemes work.
- **Logical properties and flexbox, not floats.** `margin-inline`,
  `padding-inline`, `border-inline-start` and friends follow the writing
  direction on their own, which is why `css/style-rtl.css` is down to the two
  assets that physically point one way.

## Colour schemes

All fifteen schemes from `color.inc` are available. Drupal's Color module
regenerated the theme's images and stylesheets on save; here a scheme is just a
different set of values for the `--garland-*` tokens, emitted as an inline
`:root` block by `garland_color_scheme_css()`. The tints are derived by blending
the base colour toward white using the same ratios the default token values were
read off, so a scheme now recolours the whole theme — tabs, list markers and the
navigation pointer included, which the bitmaps could not follow.

## Intentionally not ported

- **Local tasks / tabs** (`menu-local-tasks.html.twig`) — Drupal's per-node admin
  tabs have no WordPress counterpart. The CSS for `ul.primary` / `ul.secondary`
  is still in `css/garland.css` if you want to reuse the look.
- **Maintenance page** — see the table above.
- Drupal-admin-only rules (vertical tabs, dropbuttons, the status report, admin
  panels, the login block, `ol.task-list`) have been dropped from
  `css/garland.css`: they matched no WordPress markup, and they were the last
  things holding on to the bitmaps.
