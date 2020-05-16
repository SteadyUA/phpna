<?php

namespace SteadyUa\NsAnalyzer\Parser;

class Parser
{
    private $reader;

    /** @var State */
    private $state;

    public function __construct(Reader $reader, State $state)
    {
        $this->reader = $reader;
        $this->state = $state;
        $this->state->init($reader);
    }

    public function processor(): iterable
    {
        while ($this->reader->valid() && $this->findState()) {
            $result = $this->state->read($this->reader);
            if (null !== $result) {
                yield $result;
            }
        }
    }

    protected function findState(): bool
    {
        $state = $this->state->suggestState($this->reader);
        if ($state && $state !== $this->state) {
            $parent = $this->state->parent();
            while ($parent && $state === $parent) {
                if (!$this->reader->valid()) {
                    return false;
                }
                $state = $parent->suggestState($this->reader);
                $parent = $parent->parent();
            }
            if ($state) {
                $state->init($this->reader);
            }
        }
        $this->state = $state;

        return $this->state !== null;
    }

    protected function dump()
    {
        $state = $this->state;
        $path = [];
        while ($state) {
            $path[] = get_class($state);
            $state = $state->parent();
        }
        return implode(' - ', $path);
    }

}
