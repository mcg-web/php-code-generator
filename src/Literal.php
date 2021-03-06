<?php

declare(strict_types=1);

namespace Murtukov\PHPCodeGenerator;

class Literal extends AbstractGenerator
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function new(string $value)
    {
        return new static($value);
    }

    public function generate(): string
    {
        return $this->value;
    }
}
