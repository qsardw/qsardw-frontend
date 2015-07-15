<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$app['debug'] = true;

$app['database.config'] = [
    'unix_socket'=> '/var/run/mysqld/mysqld.sock',
    'dbname'=> 'qsardw',
    'user'=> 'your_user_here',
    'password'=> 'your_password_here',
    'driver'=> 'pdo_mysql',
    'charset'=> 'UTF8'
];
