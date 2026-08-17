#!/usr/bin/env bash
# Seeds the test site with content that exercises every Garland region.
# Destructive: empties the site first, so it can be re-run at any time.
set -euo pipefail
cd "$(dirname "$0")"

# wp   - run a wp-cli command, discard output
# wpid - run a wp-cli command, echo the ID it printed (--porcelain)
wp()   { docker compose run --rm -T cli "$@" >/dev/null; }
wpid() { docker compose run --rm -T cli "$@" --porcelain 2>/dev/null | tr -d '\r' | tail -1; }

# --- clean slate -----------------------------------------------------------
wp site empty --yes
for m in Primary Secondary; do
  docker compose run --rm -T cli menu delete "$m" >/dev/null 2>&1 || true
done
docker compose run --rm -T cli widget reset --all >/dev/null 2>&1 || true

# --- pages -----------------------------------------------------------------
ABOUT=$(wpid post create --post_type=page --post_status=publish --post_title="About" \
  --post_content="<p>A static page, rendered through page.php.</p><h2>Heading two</h2><p>More body copy with a <a href='#'>link</a>.</p>")
CONTACT=$(wpid post create --post_type=page --post_status=publish --post_title="Contact" \
  --post_content="<p>Contact page.</p>")

# --- posts -----------------------------------------------------------------
wp post create --post_status=publish --post_title="Hello from Garland" \
  --post_content="<p>First test post. <strong>Bold</strong>, <em>italic</em>, and a <a href='#'>link</a>.</p><blockquote><p>A blockquote.</p></blockquote><ul><li>List item</li><li>Another</li></ul>"
STICKY=$(wpid post create --post_status=publish --post_title="Sticky announcement" \
  --post_content="<p>This one is sticky.</p>")
COMMENTED=$(wpid post create --post_status=publish --post_title="Post with comments" \
  --post_content="<p>Threaded comments live below.</p>")
wp post create --post_status=publish --post_title="Another archive entry" \
  --post_content="<p>Filler so archives and pagination have something to show.</p>"

wp eval "stick_post( $STICKY );"

# taxonomy on the commented post
wp term create category Design --slug=design
wp term create post_tag drupal --slug=drupal
wp post term set "$COMMENTED" category design
wp post term set "$COMMENTED" post_tag drupal

# threaded comments on the commented post
PARENT=$(wpid comment create --comment_post_ID="$COMMENTED" --comment_approved=1 \
  --comment_author="Alice" --comment_author_email=alice@example.com \
  --comment_content="Top-level comment.")
wp comment create --comment_post_ID="$COMMENTED" --comment_approved=1 --comment_parent="$PARENT" \
  --comment_author="Bob" --comment_author_email=bob@example.com \
  --comment_content="A threaded reply, so the nesting indentation is visible."
wp comment create --comment_post_ID="$COMMENTED" --comment_approved=1 \
  --comment_author="Carol" --comment_author_email=carol@example.com \
  --comment_content="Second top-level comment, for the zebra striping."

# --- menus -----------------------------------------------------------------
wp menu create "Primary"
wp menu create "Secondary"
wp menu item add-custom Primary "Home" /
wp menu item add-post Primary "$ABOUT"
wp menu item add-post Primary "$CONTACT"
wp menu item add-custom Secondary "Log in" /wp-login.php
wp menu item add-custom Secondary "Drupal original" https://www.drupal.org/project/garland
wp menu location assign Primary primary
wp menu location assign Secondary secondary

# --- widgets ---------------------------------------------------------------
wp widget add text header --title="Header region" --text="Widget in the header region."
wp widget add text highlighted --title="Highlighted" --text="Widget in the highlighted region."
wp widget add text help --title="Help" --text="Widget in the help region."
wp widget add search sidebar-first --title="Search"
wp widget add recent-posts sidebar-first --title="Recent posts"
wp widget add categories sidebar-first --title="Categories"
wp widget add archives sidebar-second --title="Archives"
wp widget add recent-comments sidebar-second --title="Recent comments"
wp widget add text footer --title="Footer" --text="Widget in the footer region."

echo "Seeded. http://localhost:8080/  (admin / admin)"
