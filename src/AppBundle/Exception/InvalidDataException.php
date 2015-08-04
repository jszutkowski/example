<?php

namespace AppBundle\Exception;

/**
 * Description of InvalidDataException
 *
 * @author Jarek
 */
class InvalidDataException extends \Exception
{
    public function __construct($message = 'Data is invalid.')
    {
        parent::__construct($message);
    }
}
