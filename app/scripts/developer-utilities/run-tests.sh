#!/bin/bash

echo "Started at $(date +"%T %d/%m/%Y")"

if [ -z "$1" ]
  then
    ./bin/phpunit -c app/
  else
    if [ "$1" = "cc" -o "$1" = "coverage" ]
      then
        if [ "$1" = "cc" ]
          then
            php bin/console cache:clear --env=test && ./bin/phpunit -c app/
          else
            ./bin/phpunit -c app/
        fi
      else
        echo "Argument error! Available argument options: 'cc' or 'coverage'"
    fi
fi

echo "Finished at $(date +"%T %d/%m/%Y")"
