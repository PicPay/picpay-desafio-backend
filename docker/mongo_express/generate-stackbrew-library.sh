#!/usr/bin/env bash
set -Eeuo pipefail

self="$(basename "$BASH_SOURCE")"
cd "$(dirname "$(readlink -f "$BASH_SOURCE")")"

commit="$(git log -1 --format='format:%H')"
cat <<-EOH
# this file is generated via https://github.com/mongo-express/mongo-express-docker/blob/$commit/$self

Maintainers: Nick Cox <nickcox1008@gmail.com> (@knickers)
GitRepo: https://github.com/mongo-express/mongo-express-docker.git
GitCommit: $commit
EOH

# prints "$2$1$3$1...$N"
join() {
	local sep="$1"; shift
	local out; printf -v out "${sep//%/%%}%s" "$@"
	echo "${out#$sep}"
}

fullVersion="$(awk '$1 == "ENV" && $2 == "MONGO_EXPRESS" { print $3; exit }' Dockerfile)"

versionAliases=()
while [ "${fullVersion%.*}" != "$fullVersion" ]; do
	versionAliases+=( $fullVersion )
	fullVersion="${fullVersion%.*}"
done
versionAliases+=(
	latest
)

echo
cat <<-EOE
	Tags: $(join ', ' "${versionAliases[@]}")
	Architectures: amd64, arm64v8
EOE
