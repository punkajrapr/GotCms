#!/bin/bash

cd "$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
console="../bin/console"
source functions.sh

if ! commandExists $console
then
    echo "Symfony console not found"
    exit 0
fi


$console doctrine:database:drop --force
$console doctrine:database:create --if-not-exists
rm -f ../app/DoctrineMigrations/*
$console doctrine:migration:diff --no-interaction
$console doctrine:migration:migrate --no-interaction
# $console doctrine:fixtures:load --no-interaction
$console cache:clear
$console assets:install ../web
