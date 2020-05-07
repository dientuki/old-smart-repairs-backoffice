#!/bin/bash

mkdir -p phpLinter

docker-compose exec backend ./vendor/bin/phpmd app/,config/,database/,routes/,resources/views/,resources/lang/,tests/ html scripts/phpmd.xml > phpLinter/phpmd.html
docker-compose exec backend ./vendor/bin/phpcs app/ config/ database/ routes/ resources/views/ resources/lang/ tests/ --standard=PSR2 > phpLinter/phpcs.txt
