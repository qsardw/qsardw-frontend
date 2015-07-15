<?php

namespace Qsardw\Frontend\Controllers;

use Qsardw\Frontend\Application;

/**
 * Description of IndexController
 *
 * @author javiercaride
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
