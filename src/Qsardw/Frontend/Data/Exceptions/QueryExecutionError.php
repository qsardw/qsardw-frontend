<?php

namespace Qsardw\Frontend\Data\Exceptions;

use Qsardw\Frontend\QsardwException;

/**
 * Description of QueryExecutionError
 *
 * @author Javier Caride Ulloa <javier.caride@gmail.com>
 */
class QueryExecutionError extends QsardwException
{
    public function __construct($sql)
    {
        parent::__construct("QUERY_EXECUTION_FAILS::$sql");
    }
}
