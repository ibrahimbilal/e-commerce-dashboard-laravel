#!/usr/bin/env bash
set -euo pipefail

BASE="${1:-http://127.0.0.1:8000}"
COOKIE="$(mktemp)"
trap 'rm -f "$COOKIE"' EXIT

login_payload=$(curl -s -c "$COOKIE" "$BASE/admin/login" | rg -o 'name="_token" value="[^"]+"' | head -1 | sed 's/name="_token" value="//;s/"$//')
if [[ -z "${login_payload:-}" ]]; then
  echo "Could not read CSRF token from $BASE/admin/login" >&2
  exit 1
fi

curl -s -b "$COOKIE" -c "$COOKIE" -X POST "$BASE/admin/login" \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  --data-urlencode "_token=$login_payload" \
  --data-urlencode 'email=admin@example.com' \
  --data-urlencode 'password=password' \
  -o /dev/null -w 'login:%{http_code}\n'

pages=(
  /admin/dashboard
  /admin/categories/create
  /admin/customers/create
  /admin/customers
  /admin/products
  /admin/products/create
  /admin/tags/create
)

fail=0
checked=()

for page in "${pages[@]}"; do
  html=$(curl -s -b "$COOKIE" "$BASE$page")
  code=$(curl -s -o /dev/null -w '%{http_code}' -b "$COOKIE" "$BASE$page")
  echo "page $page -> $code"
  while IFS= read -r url; do
    [[ -z "$url" ]] && continue
    path=$(python3 - <<PY
from urllib.parse import urlparse
print(urlparse("$url").path or "$url")
PY
)
    [[ "$path" != /images/* ]] && continue
    if printf '%s\n' "${checked[@]:-}" | rg -Fxq "$path" 2>/dev/null; then
      continue
    fi
    checked+=("$path")
    img_code=$(curl -s -o /dev/null -w '%{http_code}' "$BASE$path")
    echo "  $path -> $img_code"
    if [[ "$img_code" != "200" ]]; then
      fail=1
    fi
  done < <(printf '%s' "$html" | rg -o '(?:src|data-flag)="[^"]+"' | sed 's/.*="//;s/"$//' | rg '/images/' || true)
done

exit "$fail"
