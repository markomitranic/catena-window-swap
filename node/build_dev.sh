#!/bin/sh

set -e

yarn install
yarn build
echo "[Success] Asset build finished."

exec "$@"

