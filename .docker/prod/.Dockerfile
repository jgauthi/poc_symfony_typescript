LABEL project="poc_symfony_typescript"

# --- Etape 1 : Build des Assets (Vite / TypeScript) ---
FROM node:20-slim AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Etape 2 : Préparation de PHP & Composer ---
FROM php:8.4-cli-alpine AS php_builder
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.* ./
RUN composer install --no-dev --optimize-autoloader --no-scripts
COPY . .
# On récupère les assets compilés par l'étape Node
COPY --from=node_builder /app/public/build ./public/build
# Nettoyage des dossiers inutiles pour le binaire
RUN rm -rf node_modules assets tests

# --- Etape 3 : Compilation du binaire statique ---
FROM dunglas/frankenphp:static-builder AS static_builder
ARG GOOS=linux
ARG GOARCH=amd64
WORKDIR /go/src/app/dist
COPY --from=php_builder /app .

# On lance le build avec les variables d'environnement Go
RUN GOOS=$GOOS GOARCH=$GOARCH ./build-static.sh