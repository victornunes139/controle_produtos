#!/bin/bash

echo "[+] Uploading Application Container"
docker-compose up -d

echo [+] Copying the configuration example file
docker exec -it produtos-api cp .env.example .env

echo [+] Installing the dependencies
docker exec -it produtos-api composer install

echo [+] Generating key
docker exec -it produtos-api php artisan key:generate

echo [+] Generating jwt secret key
docker exec -it produtos-api php artisan jwt:secret

echo [+] Creating database if not exist
docker exec -it produtos-postgres bash -c "psql -U postgres -tc \"SELECT 1 FROM pg_database WHERE datname = 'controle_produtos'\" | grep -q 1 || psql -U postgres -c \"CREATE DATABASE controle_produtos\""

echo [+] Making migrations
docker exec -it produtos-api php artisan migrate

echo [+] Making seeds
docker exec -it produtos-api php artisan db:seed

echo [+] Information of new containers
docker ps
