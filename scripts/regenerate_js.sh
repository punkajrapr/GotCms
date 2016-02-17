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

vendor="../web/assets/vendor"
jsDirectory="../src/GotCms/Bundle/BackBundle/Resources/"

cat $vendor/angular/angular.min.js \
$vendor/jquery/dist/jquery.min.js \
$vendor/bootstrap/dist/js/bootstrap.min.js \
$vendor/angular-animate/angular-animate.min.js \
$vendor/angular-aria/angular-aria.min.js \
$vendor/angular-bootstrap/ui-bootstrap.min.js \
$vendor/angular-cookies/angular-cookies.min.js \
$vendor/angular-messages/angular-messages.min.js \
$vendor/angular-translate/angular-translate.min.js \
$vendor/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js \
$vendor/angular-ui-router/release/angular-ui-router.min.js \
$vendor/CodeMirror/lib/codemirror.js \
$vendor/jQuery-contextMenu/dist/jquery.contextMenu.min.js \
$vendor/jstree/dist/jstree.min.js \
$vendor/ng-js-tree/dist/ngJsTree.min.js  > vendor.min.js

cat $jsDirectory/public/js/generic-classes.js \
$jsDirectory/public/js/gotcms.js >> gotcms.min.js

for jsType in {"vendor","gotcms"}; do
    java -jar ../vendor/bin/yuicompressor.jar $jsType.min.js \
        -o $jsDirectory/public/js/$jsType.min.js --charset utf-8 --type js

    rm $jsType.min.js
done
