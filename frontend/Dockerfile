ARG NODE_VERSION=20.17.0

FROM node:${NODE_VERSION}-slim as base

ARG PORT=3000

ENV NODE_ENV=production

WORKDIR /src

#build
FROM base as build

COPY --link package.json package-lock.json ./
RUN npm install --production=false

COPY --link . .

RUN npm run build
RUN npm prune

# Run
FROM base

ENV PORT=$PORT

COPY --from=build /src/.nuxt /src/.nuxt
COPY --from=build /src/static /src/static
COPY --from=build /src/package.json /src/package.json

# Start the application
CMD [ "npm", "start" ]
