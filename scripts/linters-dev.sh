#!/bin/bash

mkdir -p phpLinter
cd phpLinter

docker-compose exec backend ./vendor/bin/phpmd app/,routes/,resources/views/,resources/lang/,tests/ html cleancode,codesize,controversial,design,naming,unusedcode > phpmd.html