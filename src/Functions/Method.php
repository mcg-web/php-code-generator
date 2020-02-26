<?php

declare(strict_types=1);

namespace Murtukov\PHPCodeGenerator\Functions;

use Murtukov\PHPCodeGenerator\GeneratorInterface;
use Murtukov\PHPCodeGenerator\Traits\FunctionTrait;
use Murtukov\PHPCodeGenerator\Traits\IndentableTrait;
use Murtukov\PHPCodeGenerator\Traits\ScopedContentTrait;
use function implode;

class Method implements GeneratorInterface
{
    use IndentableTrait;
    use ScopedContentTrait;
    use FunctionTrait;

    private string  $name;
    private string  $modifier;
    private array   $customStack = [];

    public static function create(string $name, string $modifier = 'public', string $returnType = ''): self
    {
        return new self($name, $modifier, $returnType);
    }

    public function __construct(string $name, string $modifier = 'public', string $returnType = '')
    {
        $this->name = $name;
        $this->modifier = $modifier;
        $this->returnType = $returnType;
    }

    public function generate(): string
    {
        $signature = "$this->modifier function $this->name()";

        if ($this->returnType) {
            $signature .= ": $this->returnType";
        }

        return <<<CODE
        $signature
        {
        {$this->generateContent()}
        }
        CODE;
    }

    private function generateContent(): string
    {
        $content = '';

        if (!empty($this->content)) {
            $content = $this->indent(implode(";\n", $this->content).';');
        }

        return $content;
    }

    private function buildReturnType(): string
    {
        return $this->returnType ? ": $this->returnType" : '';
    }

    public function __toString(): string
    {
        return $this->generate();
    }

    public function getReturnType(): string
    {
        return $this->returnType;
    }

    public function setReturnType(string $returnType): Method
    {
        $this->returnType = $returnType;
        return $this;
    }
}