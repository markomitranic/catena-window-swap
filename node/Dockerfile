FROM node:14-stretch-slim AS base
USER root
ENV NODE_ENV=development
WORKDIR /app/src/

FROM base AS dev
ENTRYPOINT []
CMD ["tail", "-f", "/dev/null"]
COPY build_dev.sh /app/build.sh

FROM base AS prod
COPY ./src/ /app/src/
RUN yarn install && yarn build
