<?php

namespace Apiato\Core\Exceptions;

use App\Base\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class WrongConfigurationsException
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class WrongConfigurationsException extends Exception
{

    public $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Ops! Some Packages configurations are incorrect!';

}
