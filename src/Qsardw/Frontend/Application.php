<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Qsardw\Frontend;

use Silex\Application as SilexApp;

/**
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class Application extends SilexApp
{
    const TIMESTAMP = 'Y-m-d H:i:s';

    /**
     * Returns the application logger
     *
     * @return \Monolog\Logger
     */
    public function logger()
    {
        return $this['logger'];
    }

    /**
     * Returns the twig template engine
     *
     * @return \Twig_Environment
     */
    public function twig()
    {
        return $this['twig'];
    }
}
