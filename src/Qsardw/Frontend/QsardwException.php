<?php

namespace Qsardw\Frontend;

/**
 * Description of QsardwException
 *
 * @author Javier Caride Ulloa <javier.caride@gmail.com>
 */
class QsardwException extends \Exception implements Exception
{

    public function __construct($message, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
