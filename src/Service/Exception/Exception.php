<?php

declare(strict_types=1);

namespace App\Service\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class Exception extends HttpException
{

    public function __construct(private ExceptionData $exceptionData)
    {
        $statusCode = $exceptionData->getStatusCode();
        $message = $exceptionData->getType();
        parent::__construct($statusCode, $message);
    }

    /**
     * @return ExceptionData
     */
    public function getExceptionData(): ExceptionData
    {
        return $this->exceptionData;
    }


}