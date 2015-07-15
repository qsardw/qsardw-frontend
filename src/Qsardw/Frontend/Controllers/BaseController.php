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

use Qsardw\Frontend\Application;

/**
 * Base controller for the Web Application
 *
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
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
