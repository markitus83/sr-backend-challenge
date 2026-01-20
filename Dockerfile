FROM php:8.1-cli-alpine
LABEL authors="Marc.G.V"

RUN apk add --no-cache git unzip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
