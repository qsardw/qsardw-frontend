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
 * Controller for managing user profile
 *
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class UserController extends BaseController
{
    public function profile(Application $app)
    {
        $templateData = array();
        return $app->twig()->render(
            'user/profile.twig',
            $templateData
        );
    }
}
