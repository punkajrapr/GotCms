# GotCms

Master status: [![Build Status](https://travis-ci.org/GotCms/GotCms.png?branch=master)](https://travis-ci.org/GotCms/GotCms)
[![Latest Stable Version](https://poser.pugx.org/GotCms/GotCms/v/stable.png)](https://packagist.org/packages/GotCms/GotCms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GotCms/GotCms/badges/quality-score.png?s=fa6f300890dac808070c12b50a9f7d19859ca9ec)](https://scrutinizer-ci.com/g/GotCms/GotCms/)

## About GotCms

* GotCms is a **Content Management System** (CMS) based on [Symfony 3](http://symfony.com/) which enables you to build websites and powerful online applications.
* [Official site](http://got-cms.com)
* This product has been made available under the terms of the GNU Lesser General Public License version 3.
* Please read the [LICENSE.txt](https://github.com/GotCms/GotCms/blob/master/LICENSE.txt) file for the exact license details that apply to GotCms.
* See [features](http://got-cms.com/discover/features)

## Release information

### Updates in 2.0.0-alpha

Please see [CHANGELOG.md](https://github.com/GotCms/GotCms/blob/master/CHANGELOG.md).


## Installation

This projet depends on [GotCms Angular Backend](https://github.com/GotCms/angular-backend).

- Clone this repository `git clone https://github.com/GotCms/GotCms.git`
- Get Composer using curl `curl -s http://getcomposer.org/installer | php`
- Install dependencies `composer.phar install`
- Deploy the database `./scripts/build.sh`

### Apache configuration

If you want to use VirtualHost, copy the .htaccess content otherwise check if "AllowOverride" is set to "All".

Example of VirtualHost:

```
<VirtualHost *:80>
    ServerAdmin admin@got-cms.com
    ServerName got-cms.com
    DocumentRoot /var/www/gotcms/web

    <Directory /var/www/gotcms/web>
        DirectoryIndex app.php
        Options Indexes FollowSymLinks MultiViews
        AllowOverride None
        Order allow,deny
        Allow from all

        <IfModule mod_negotiation.c>
            Options -MultiViews
        </IfModule>

        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_URI}::$1 ^(/.+)/(.*)::\2$
            RewriteRule ^(.*) - [E=BASE:%1]

            # Sets the HTTP_AUTHORIZATION header removed by Apache
            RewriteCond %{HTTP:Authorization} .
            RewriteRule ^ - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

            RewriteCond %{ENV:REDIRECT_STATUS} ^$
            RewriteRule ^app\.php(?:/(.*)|$) %{ENV:BASE}/$1 [R=301,L]

            RewriteCond %{REQUEST_FILENAME} -f
            RewriteRule ^ - [L]

            RewriteRule ^ %{ENV:BASE}/app.php [L]
        </IfModule>
    </Directory>
</VirtualHost>
```


###Required

- An HTTP server
- Php version >= 5.5.9
- XML support
- FileInfo support
- Mbstring support
- Json support
- Curl support
- PDO support
- A database supported by PDO.
    - MySQL
    - PostgreSQL


### Recommended

Actually only tested with Apache HTTP server.
Php configuration:
- Display Errors: Off
- File Uploads: On
- Magic Quotes Runtime: Off
- Magic Quotes GPC: Off
- Register Globals: Off
- Session Auto Start: Off
