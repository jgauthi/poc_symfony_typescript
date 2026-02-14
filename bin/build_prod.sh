#!/bin/bash
set -e

cd "$(dirname "$0")/.."

# Configuration
OS_TARGET=${1:-linux}
BUILD_DIR="var/build"
DOTENV_DEST="$BUILD_DIR/.env"
DOTENV_SOURCE=".docker/prod/.env"
DOCKERFILE_PATH=".docker/prod/.Dockerfile"

# Définition du nom du binaire
if [ "$OS_TARGET" == "windows" ]; then
    BINARY_NAME="app-windows.exe"
    GOOS="windows"
else
    BINARY_NAME="app-linux"
    GOOS="linux"
fi

echo "🚀 Préparation du build pour $OS_TARGET dans $BUILD_DIR..."

mkdir -p "$BUILD_DIR/data"
mkdir -p "$BUILD_DIR/var/log"

docker build \
    --build-arg GOOS=$GOOS \
    --build-arg GOARCH=amd64 \
    -t "symfony-build-$OS_TARGET" \
    -f "$DOCKERFILE_PATH" .

echo "📦 Extraction du binaire..."
docker run --rm --entrypoint cat "symfony-build-$OS_TARGET" /go/src/app/dist/frankenphp > "$BUILD_DIR/$BINARY_NAME"

if [ "$OS_TARGET" == "linux" ]; then
    chmod +x "$BUILD_DIR/$BINARY_NAME"
fi

# 3. Gestion du fichier .env
if [ ! -f "$DOTENV_DEST" ]; then
    if [ -f "$DOTENV_SOURCE" ]; then
        echo "📝 Copie du fichier .env depuis $DOTENV_SOURCE..."
        cp "$DOTENV_SOURCE" "$DOTENV_DEST"

        # Génération et injection de l'APP_SECRET
        NEW_SECRET=$(openssl rand -hex 16)
        # Remplace la ligne APP_SECRET ou l'ajoute si elle n'existe pas
        if grep -q "APP_SECRET=" "$DOTENV_DEST"; then
            sed -i "s/APP_SECRET=.*/APP_SECRET=$NEW_SECRET/" "$DOTENV_DEST"
        else
            echo "APP_SECRET=$NEW_SECRET" >> "$DOTENV_DEST"
        fi

        # Configuration du Host pour FrankenPHP à partir de DEFAULT_URI
        # On extrait la valeur de DEFAULT_URI pour définir SERVER_NAME
        DEFAULT_URI_VAL=$(grep "DEFAULT_URI=" "$DOTENV_DEST" | cut -d'=' -f2)
        if [ ! -z "$DEFAULT_URI_VAL" ]; then
            echo "🌐 Configuration du host : $DEFAULT_URI_VAL"
            if grep -q "SERVER_NAME=" "$DOTENV_DEST"; then
                sed -i "s|SERVER_NAME=.*|SERVER_NAME=$DEFAULT_URI_VAL|" "$DOTENV_DEST"
            else
                echo "SERVER_NAME=$DEFAULT_URI_VAL" >> "$DOTENV_DEST"
            fi
        fi
    else
        echo "⚠️ Erreur : Fichier source $DOTENV_SOURCE introuvable."
        exit 1
    fi
fi

echo "🧹 Nettoyage des images du projet..."
docker image prune -a -f --filter "label=project=poc_symfony_typescript" --filter "until=168h"

echo "---"
echo "✅ Terminé ! Binaire disponible dans $BUILD_DIR/$BINARY_NAME"