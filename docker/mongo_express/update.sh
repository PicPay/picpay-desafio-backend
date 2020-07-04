#!/usr/bin/env bash
set -Eeuo pipefail

cd "$(dirname "$(readlink -f "$BASH_SOURCE")")"

mongoExpressVersion="$(wget -qO- 'https://registry.npmjs.org/mongo-express' | jq -r '."dist-tags".latest')"

echo "$mongoExpressVersion"

sed -ri "s/^(ENV MONGO_EXPRESS) .*$/\1 $mongoExpressVersion/" Dockerfile
