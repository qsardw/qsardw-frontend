<?php

namespace Qsardw\Frontend\Controllers;

use Qsardw\Frontend\Application;

class BaseController
{
    const POST_METHOD = 'POST';
    const GET_METHOD = 'GET';
    const DELETE_METHOD = 'DELETE';
    const PUT_METHOD = 'PUT';

    public function __construct()
    {
    }

    /**
     * Returns the authenticated user
     *
     * @param Application $app
     * @return mixed
     * @throws \Exception
     */
    protected function getAuthenticatedUser(Application $app)
    {
        $securityToken = $app['security']->getToken();
        if (null !== $securityToken) {
            return $securityToken->getUser();
        } else {
            throw new \Exception('USER_NOT_AUTHENTICATED');
        }
    }
}
