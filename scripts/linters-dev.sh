#!/bin/bash

mkdir -p phpLinter

docker-compose exec backend ./vendor/bin/phpmd app/,routes/,resources/views/,resources/lang/,tests/ html scripts/phpmd.xml > phpLinter/phpmd.html