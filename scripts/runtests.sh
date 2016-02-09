#!/bin/bash

cd "$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

source functions.sh

if ! commandExists phpunit
then
    if ! commandExists ../vendor/bin/phpunit
    then
        echo "Phpunit not found"
        exit 0
    else
        phpunit="../vendor/bin/phpunit"
    fi
else
    phpunit="phpunit"
fi

phpunit_opts="-c ../ -d zend.enable_gc=0 --verbose"
$phpunit $phpunit_opts
