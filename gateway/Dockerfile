FROM nginx:latest AS base

COPY conf/nginx.conf /etc/nginx/nginx.conf
COPY conf/default.conf /etc/nginx/conf.d/default.conf
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/

FROM base AS dev
COPY conf/default_dev.conf /etc/nginx/conf.d/default.conf

FROM base AS prod
COPY --from=windowswap_node /app/src/public /app/src/public
COPY --from=windowswap_node /app/src/build /app/src/public/build

COPY conf/ssl /etc/nginx/ssl
