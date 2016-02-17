#!/bin/bash

cd "$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

source functions.sh
lessc="../vendor/bin/lessc"
if ! commandExists $lessc
then
    echo "Lessc not found"
    exit 0
fi

cssDirectory="../src/GotCms/Bundle/BackBundle/Resources"
$lessc -x "$cssDirectory/assets/less/gotcms.less" > "$cssDirectory/public/css/gotcms.min.css"
