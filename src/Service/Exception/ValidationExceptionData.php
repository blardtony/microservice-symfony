<?php

declare(strict_types=1);

namespace App\Service\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationExceptionData extends ExceptionData
{

    public function __construct(int $statusCode, string $type, private ConstraintViolationList $constraintViolationList)
    {
        parent::__construct($statusCode, $type);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'violations' => $this->getViolationsArray()
        ];
    }

    public function getViolationsArray(): array
    {
        $violations = [];
        foreach ($this->constraintViolationList as $violation) {
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage()
            ];
        }
        return $violations;
    }
}