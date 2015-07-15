<?php

namespace Qsardw\Frontend\Controllers;

use Qsardw\Frontend\Data\Users;
use Qsardw\Frontend\Data\Dataset;
use Qsardw\Frontend\Application;

/**
 * Description of IndexController
 *
 * @author javiercaride
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
