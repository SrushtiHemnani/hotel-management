<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;

// Initialize Capsule
$capsule = new Capsule;

define("BASE_PATH", "http://localhost:8000/");

// Add database connection
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'hotel_db_1',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set Capsule instance globally
$capsule->setAsGlobal();

// Boot Eloquent ORM
$capsule->bootEloquent();

// Log all queries
$capsule::listen(function ($query) {
    echo "1111111111111111111111";
    file_put_contents('query.log', $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL, FILE_APPEND);
});