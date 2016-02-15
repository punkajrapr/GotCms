#!/bin/bash

cd "$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

source functions.sh

if ! commandExists java
then
    echo "Java not found"
    exit 0
fi

if [[ ! -f ../vendor/bin/yuicompressor.jar ]]
then
    echo "yuicompressor.jar not found"
    exit 0
fi

jsDirectory="../public/backend/js"
jsDirectory="../src/GotCms/Bundle/BackBundle/Resources/assets/js"

cat $jsDirectory/generic-classes.js \
$jsDirectory/gotcms.js > gotcms.min.js

java -jar ../vendor/bin/yuicompressor.jar gotcms.min.js \
-o $jsDirectory/gotcms.min.js --charset utf-8 --type js

rm gotcms.min.js
