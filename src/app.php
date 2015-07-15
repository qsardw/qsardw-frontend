<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Qsardw\Frontend\Security\UserProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new SecurityServiceProvider());
$app->register(new RememberMeServiceProvider());
$app->register(new UrlGeneratorServiceProvider());

$app['security.encoder.digest'] = $app->share(function () {
    return new MessageDigestPasswordEncoder('md5', false, 1);
});

$app['security.firewalls'] = array(
    'login' => array(
        'pattern' => '^/login$',
    ),
    'secured' => array(
        'pattern' => '^.*$',
        'form' => array('login_path' => '/login', 'check_path' => '/user/authenticate'),
        'logout' => array('logout_path' => '/user/logout'),
        'users' => $app->share(function () use ($app) {
            return new UserProvider($app['db']);
        }),
        'remember_me' => array(
            'key' => 'YWNiZDE4ZGI0Y2MyZjg1Y2VkZWY2NTRmY2NjNGE0ZDg=',
            'always_remember_me' => true
        )
    )
);

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => APP_LOGS_FOLDER . DIRECTORY_SEPARATOR . 'qsardw-frontend.log',
    'monolog.name' => 'qsardw-frontend'
));

$app->register(
    new TwigServiceProvider(),
    array(
        'twig.path' => APP_FOLDER . DIRECTORY_SEPARATOR . 'resources/templates',
        'twig.options' => [
            'cache' => APP_CACHE_FOLDER . DIRECTORY_SEPARATOR . 'twig'
        ]
    )
);

$app->register(
    new DoctrineServiceProvider(),
    array(
        'db.options' => $app['database.config']
    )
);
