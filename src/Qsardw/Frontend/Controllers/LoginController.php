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
 * Controller for managing login operations
 *
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
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
