#!/bin/bash

mkdir -p phpLinter

echo "=== PHP Mess Detector ==="
docker-compose exec backoffice ./vendor/bin/phpmd app/,config/,database/,routes/,resources/views/,resources/lang/,tests/ text scripts/phpmd.xml
echo "=== PHP CodeSniffer ==="
docker-compose exec backoffice ./vendor/bin/phpcs app/ config/ database/ routes/ resources/views/ resources/lang/ tests/ --standard=PSR2
echo "=== PHP Static Analysis Tool ==="
docker-compose exec backoffice ./vendor/bin/phpstan analyse -c scripts/phpstan.neon
echo "=== PHP Magic Number Detector ==="
docker-compose exec backoffice ./vendor/bin/phpmnd app/ config/ database/ routes/ resources/views/ resources/lang/ tests/