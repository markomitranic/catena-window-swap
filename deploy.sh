#!/bin/sh

set -a
[ -f .env ] && . ./.env
[ -f .env.local ] && . ./.env.local
set +a

docker build ./node -t windowswap_node --target prod

docker-compose down --remove-orphans
docker-compose build
docker-compose up --remove-orphans -d
