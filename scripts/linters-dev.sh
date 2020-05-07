#!/bin/bash

mkdir -p phpLinter

docker-compose exec backoffice ./vendor/bin/phpmd app/,config/,database/,routes/,resources/views/,resources/lang/,tests/ html scripts/phpmd.xml > phpLinter/phpmd.html
docker-compose exec backoffice ./vendor/bin/phpcs app/ config/ database/ routes/ resources/views/ resources/lang/ tests/ --standard=PSR2 > phpLinter/phpcs.txt
docker-compose exec backoffice ./vendor/bin/phpstan analyse -l 0 app/ config/ database/ routes/ resources/views/ resources/lang/ tests/
