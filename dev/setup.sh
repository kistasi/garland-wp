#!/usr/bin/env bash
# Bring up the stack, install WordPress, activate the theme and seed content.
# Safe to re-run: the install step is skipped if WordPress is already installed.
set -euo pipefail
cd "$(dirname "$0")"

URL=${URL:-http://localhost:8080}

docker compose up -d db wordpress

printf 'waiting for wordpress'
for _ in $(seq 1 60); do
  code=$(curl -s -o /dev/null -w '%{http_code}' "$URL/" || true)
  [ "$code" != "000" ] && break
  printf '.'
  sleep 2
done
printf '\n'
[ "${code:-000}" = "000" ] && { echo "wordpress did not come up at $URL" >&2; exit 1; }

if docker compose run --rm -T cli core is-installed 2>/dev/null; then
  echo "WordPress already installed, skipping core install."
else
  docker compose run --rm -T cli core install \
    --url="$URL" --title="Garland Test" \
    --admin_user=admin --admin_password=admin \
    --admin_email=admin@example.com --skip-email
fi

docker compose run --rm -T cli theme activate garland
docker compose run --rm -T cli rewrite structure '/%postname%/'

./seed.sh
