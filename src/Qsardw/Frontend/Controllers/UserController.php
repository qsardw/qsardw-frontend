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
use Qsardw\Frontend\Data\Users;
use Qsardw\Frontend\QsardwException;

/**
 * Controller for managing user profile
 *
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class UserController extends BaseController
{
    public function profile(Application $app)
    {
        $usersDao = new Users($app['db']);
        $templateData = [
            'user' => $usersDao->getUser($this->getAuthenticatedUser($app)->getId())
        ];
        return $app->twig()->render(
            'user/profile.twig',
            $templateData
        );
    }

    /**
     * Saves the changes of the user profile
     *
     * @param Application $app
     * @return string
     * @throws QsardwException
     * @throws \Exception
     */
    public function saveProfile(Application $app)
    {
        $usersDao = new Users($app['db']);
        $postParams = $app['request']->request->all();

        if (!isset($postParams['password']) || !isset($postParams['confirm_password'])) {
            throw new QsardwException('New password must be provided');
        }

        if ($postParams['password'] !== $postParams['confirm_password']) {
            throw new QsardwException('Passwords do not match');
        }

        $authenticatedUser = $this->getAuthenticatedUser($app);
        $encoder = $app['security.encoder_factory']->getEncoder($authenticatedUser);

        $queryParams = [
            'id' => $this->getAuthenticatedUser($app)->getId(),
            'complete_name' => $postParams['complete_name'],
            'password' => $encoder->encodePassword($postParams['password'], $authenticatedUser->getSalt())
        ];

        $usersDao->updateUser($queryParams);

        $templateData = [];
        return $app->twig()->render(
            'user/profile_saved.twig',
            $templateData
        );
    }
}
