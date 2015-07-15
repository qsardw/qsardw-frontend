<?php

// Enable the debug mode
$app['debug'] = true;

$app['database.config'] = [
    'unix_socket'=> '/var/run/mysqld/mysqld.sock',
    'dbname'=> 'qsardw',
    'user'=> 'your_user_here',
    'password'=> 'your_password_here',
    'driver'=> 'pdo_mysql',
    'charset'=> 'UTF8'
];
