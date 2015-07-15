<?php

$app['database.config'] = [
    'unix_socket'=> '/var/run/mysqld/mysqld.sock',
    'dbname'=> 'qsardw',
    'user'=> 'your_user_here',
    'password'=> 'your_password_here',
    'driver'=> 'pdo_mysql',
    'charset'=> 'UTF8'
];

$app['uploads.config'] = [
    "basePath" => "/qsardw/data/uploads",
    "prefix" => "dataset"
];
