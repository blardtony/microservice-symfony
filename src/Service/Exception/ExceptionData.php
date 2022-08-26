<?php

declare(strict_types=1);

namespace App\Service\Exception;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionData extends HttpException
{

    public function __construct(private int $statusCode, private string $type)
    {
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}