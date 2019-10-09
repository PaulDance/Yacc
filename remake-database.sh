#! /bin/bash

set -e
rm ./var/data.db
./bin/console doctrine:database:create
./bin/console doctrine:schema:create
./bin/console doctrine:fixtures:load -n
