#!/bin/sh

set -a
[ -f .env ] && . ./.env
[ -f .env.local ] && . ./.env.local
set +a

# Register shutdown handler
function gracefulShutdown ()
{
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml down --remove-orphans || true
	docker system prune -f && docker image prune -f
	exit 2
}
trap "gracefulShutdown" 2

docker-compose -f docker-compose.yml -f docker-compose-dev.yml down --remove-orphans
docker-compose -f docker-compose.yml -f docker-compose-dev.yml build
docker-compose -f docker-compose.yml -f docker-compose-dev.yml up --remove-orphans
