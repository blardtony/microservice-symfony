<?php

declare(strict_types=1);

namespace App\Filter\Modifier\Factory;

use App\Filter\Modifier\PriceModifierInterface;

interface PriceModifierFactoryInterface
{
    public function create(string $modifierType): PriceModifierInterface;
}