<?php

namespace Qsardw\Frontend\Controllers;

use Qsardw\Frontend\Application;

/**
 * Description of IndexController
 *
 * @author javiercaride
 */
class LoginController extends BaseController
{
    public function loginForm(Application $app)
    {
        return $app->twig()->render(
            'loginform.twig',
            array(
                'error'         => $app['security.last_error']($app['request']),
                'last_username' => $app['session']->get('_security.last_username'),
            )
        );
    }
}
