<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Qsardw\Frontend\Controllers;

use Qsardw\Frontend\Data\Users;
use Qsardw\Frontend\Data\Dataset;
use Qsardw\Frontend\Application;

/**
 * Dataset for index page
 *
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class IndexController extends BaseController
{
    public function index(Application $app)
    {
        $usersDao = new Users($app['db']);
        $user = $usersDao->getUser($this->getAuthenticatedUser($app)->getId());

        $datasetsDao = new Dataset($app['db']);
        $app->logger()->debug('Accesing index controller');

        return $app->twig()->render(
            'index/index.twig',
            array(
                'user' => $user,
                'clean_datasets' => $datasetsDao->countCleanByOwner($user['id']),
                'pending_datasets' => $datasetsDao->countPendingByOwner($user['id']),
                'cleaning_datasets' => $datasetsDao->countCleaningByOwner($user['id']),
                'error_datasets' => $datasetsDao->countErrorsByOwner($user['id'])
            )
        );
    }
}
