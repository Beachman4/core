<?php

namespace Apiato\Core\Exceptions;

use App\Base\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class CoreInternalErrorException
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class CoreInternalErrorException extends Exception
{

    public $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Something went wrong!';

}
