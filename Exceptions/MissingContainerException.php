<?php

namespace Apiato\Core\Exceptions;

use App\Base\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class MissingContainerException
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class MissingContainerException extends Exception
{

    public $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Package not installed.';

}
