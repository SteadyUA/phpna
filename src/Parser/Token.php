<?php

namespace SteadyUa\NsAnalyzer\Parser;

class Token
{
    private $code;
    private $text;

    public function __construct(int $code, string $text)
    {
        $this->code = $code;
        $this->text = $text;
    }

    public function eq($definition)
    {
        if (is_int($definition)) {
            return $this->code == $definition;
        }

        return $this->text == $definition;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function name(): string
    {
        if ($this->code == -1) {
            return '_';
        }

        return token_name($this->code);
    }
}
