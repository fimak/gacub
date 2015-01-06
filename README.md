Google Analytics Campaign URL Builder
=====================================


REQUIREMENTS
------------

The application based on yii2 basic application template.
The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Git and Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this application using the following command:

~~~
git clone https://github.com/fimak/gacub.git gacub
php composer.phar global require "fxp/composer-asset-plugin:1.0.0-beta4"
php composer.phar update
~~~


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=gacub',
    'username' => 'root',
    'password' => 'toor',
    'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.

Also check and edit the other files in the `config/` directory to customize your application.
