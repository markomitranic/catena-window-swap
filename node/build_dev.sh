#!/bin/sh

set -e

yarn install
yarn build

echo "[Success|Ready] Asset build finished."
