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

use Monolog\Logger;

/**
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class Object
{
    /**
     * Current Logger
     *
     * @var \Monolog\Logger
     */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->setLogger($logger);
    }

    /**
     * Returns the logger for the current execution environment
     *
     * @return \Monolog\Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Sets the logger for the current execution environment
     *
     * @param \Monolog\Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
}
