<?php

namespace SteadyUa\NsAnalyzer\Parser;

abstract class State
{
    /** @var State|null */
    private $parent;

    public function __construct(State $parent = null)
    {
        $this->parent = $parent;
    }

    public function init(Reader $reader)
    {
    }

    abstract public function read(Reader $reader): ?string;

    abstract public function suggestState(Reader $reader): ?State;

    public function parent(): ?State
    {
        return $this->parent;
    }
}
