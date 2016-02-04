#!/bin/bash

cd "$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

source functions.sh

if ! commandExists phpcs
then
    if ! commandExists ../vendor/bin/phpcs
    then
        echo Could not find phpcs.
        exit 0
    else
        phpcs="../vendor/bin/phpcs"
    fi
else
    phpcs="phpcs"
fi

standard=Got
if [[ -d "../vendor/gotcms/gotsniffs/Got/" ]]
then
    standard="../vendor/gotcms/gotsniffs/Got/"
fi

if [[ $# -gt 0 ]]
then
    $phpcs --standard=$standard $*
else
    $phpcs --standard=$standard ../src/
fi
