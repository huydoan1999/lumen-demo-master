<?php

return  [

    'default' => 'mongodb',

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'dump_command_path' => '/opt/lampp/bin', // only the path, so without 'mysqldump' or 'pg_dump'
            'dump_command_timeout' => 60 * 5, // 5 minute timeout
            'dump_using_single_transaction' => true, // perform dump using a single transaction
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'thekings_admin'),
            'username' => env('DB_USERNAME', 'thekingsadmin'),
            'password' => env('DB_PASSWORD', 'the!King@dmin2018888'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'name' => 'mysql'
        ],
        //https://docs.mongodb.com/manual/reference/method/db.createUser/
        'mongodb_rocketchat' => array(
            'driver' => 'mongodb',
            'host' => env('MONGODB_ROCKETCHAT_HOST', 'c.tanca.io'),
            'port' => env('MONGODB_ROCKETCHAT_PORT', 27019),
            'username' => env('MONGODB_ROCKETCHAT_USERNAME', 'urocket'),
            'password' => env('MONGODB_ROCKETCHAT_PASSWORD', 'chat2017pss'),
            'database' => env('MONGODB_ROCKETCHAT_DATABASE', 'rocketchat'),
            'use_mongo_id' => true,
            'options' => array(
                  'database' => env('MONGODB_AUTHDATABASE', 'rocketchat'),
            ),
            'name' => 'mongodb_rocketchat'
        ),
        'mongodb' => array(
            'driver' => 'mongodb',
            'host' => env('MONGODB_HOST', 'c.tanca.io'),
            'port' => env('MONGODB_PORT', 27019),
            'username' => env('MONGODB_USERNAME', 'thekingsapi'),
            'password' => env('MONGODB_PASSWORD', 'the!King@pi17@'),
            'database' => env('MONGODB_DATABASE', 'thekings_api'),
            'use_mongo_id' => true,
            'options' => array(
                  'database' => env('MONGODB_AUTHDATABASE', 'thekings_api'),
            ),
            'name' => 'mongodb'
        ),

    ],
    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */
    'redis' => [
        'cluster' => env('REDIS_CLUSTER', false),
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DATABASE', 0),
            'password' => env('REDIS_PASSWORD', null),
        ],
    ],

];
