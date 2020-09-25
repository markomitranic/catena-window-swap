FROM node:14-stretch-slim AS base
USER root
ENV NODE_ENV=development
WORKDIR /app/src/

FROM base AS dev
COPY build_dev.sh /app/build.sh
ENTRYPOINT ["bash", "/app/build.sh"]
CMD ["yarn", "start"]

FROM base AS prod
COPY ./src/ /app/src/
RUN yarn install && yarn build
