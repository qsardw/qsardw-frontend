<?php

namespace Qsardw\Frontend;

use Monolog\Logger;

/**
 * Description of Object
 *
 * @author javiercaride
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
