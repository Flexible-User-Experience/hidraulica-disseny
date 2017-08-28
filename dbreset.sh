#!/bin/bash

if [ -z "$1" ]
  then
    php app/console doctrine:database:drop --force
    php app/console doctrine:database:create
    # php app/console doctrine:schema:update --force
    # php app/console doctrine:migrations:diff
    php app/console doctrine:migrations:mig
    php app/console hautelook_alice:doctrine:fixtures:load -n
  else
    if [ "$1" = "dev" -o "$1" = "test" -o "$1" = "prod" ]
      then
        php app/console doctrine:database:drop --force --env="$1"
        php app/console doctrine:database:create --env="$1"
        php app/console doctrine:schema:update --force --env="$1"
        php app/console hautelook_alice:doctrine:fixtures:load -n --env="$1"
      else
        echo "Argument error! Available argument options: 'prod', 'dev' or 'test'"
    fi
fi
