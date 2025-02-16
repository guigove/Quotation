#!/bin/bash

set -e

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

./vendor/bin/sail up -d --build
./vendor/bin/sail composer install

./vendor/bin/sail artisan jwt:secret

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate --seed

echo "Setup finished! API available at http://localhost and frontend at http://localhost:4200"
