<?php

namespace Qsardw\Frontend;

use Silex\Application as SilexApp;

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
