Silex PHP Redis Extension Provider
================

Installation
------------

Create (or add to your) composer.json in your projects root-directory:

    {
        "require": {
            "furester/silex-php-redis": "*"
        }
    }

and run:

    curl -s http://getcomposer.org/installer | php
    php composer.phar install

This is just a silex provider module for phpredis extension, you will need to setup Redis (https://github.com/antirez/redis) and phpredis extension (https://github.com/nicolasff/phpredis).

Note that Redis and RedisCluster don't implement a common interface and they use different methods for some operations,
you have to consider this in your code.

Example
----------------

Check out simple example under "example" directory.

To run the examples:

    composer update
    php -S 127.0.0.1:8081 example/example.php

License
-------

'silex-php-redis' is licensed under the MIT license.
