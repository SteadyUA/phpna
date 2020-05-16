<?php

namespace SteadyUa\NsAnalyzer\Parser;

use ArrayIterator;
use Iterator;
use RuntimeException;

class Reader
{
    /**
     * @var Iterator&ArrayIterator|Token[]
     */
    private $chainIterator;
    private $position;

    public function __construct(Sequence $chain)
    {
        $this->chainIterator = $chain->getIterator();
        $this->chainIterator->rewind();
        $this->position = 0;
    }

    public function readTo(... $definitions): ?Sequence
    {
        if (!$this->valid()) {
            return null;
        }
        $position = $this->position;
        $chain = new Sequence();
        $this->next();
        while ($this->valid()) {
            $token = $this->current();
            foreach ($definitions as $definition) {
                if ($token->eq($definition)) {
                    return $chain;
                }
            }
            $chain->add($token);
            $this->next();
        }
        $this->chainIterator->seek($position);
        $this->position = $position;

        return null;
    }

    public function current(): Token
    {
        return $this->chainIterator->current();
    }

    public function right(int $offset)
    {
        return $this->chainIterator[$this->position + $offset];
    }

    public function left(int $offset)
    {
        return $this->chainIterator[$this->position - $offset];
    }

    public function matchLeft(... $definitions): Sequence
    {
        $match = [];
        $offset = $this->position - 1;
        do {
            $token = $this->chainIterator[$offset];
            $hasMatch = false;
            foreach ($definitions as $definition) {
                if ($token->eq($definition)) {
                    $hasMatch = true;
                    array_unshift($match, $token);
                    break;
                }
            }
            $offset --;
        } while ($offset >= 0 && $hasMatch);

        return new Sequence($match);
    }

    public function matchRight(... $definitions): Sequence
    {
        $match = [];
        $offset = $this->position + 1;
        do {
            $token = $this->chainIterator[$offset];
            $hasMatch = false;
            foreach ($definitions as $definition) {
                if ($token->eq($definition)) {
                    $hasMatch = true;
                    array_push($match, $token);
                    break;
                }
            }
            $offset ++;
        } while ($offset < count($this->chainIterator) && $hasMatch);

        return new Sequence($match);
    }

    public function move(int $offset)
    {
        $position = $this->position + $offset;
        if ($position < 0) {
            throw new RuntimeException('Negative position.');
        } elseif ($position > count($this->chainIterator) - 1) {
            throw new RuntimeException('Invalid position.');
        }
        $this->chainIterator->seek($position);
        $this->position = $position;
    }

    public function next(): ?Token
    {
        if ($this->chainIterator->valid()) {
            $this->position ++;
            $this->chainIterator->next();
        }

        return $this->chainIterator->current();
    }

    public function valid(): bool
    {
        return $this->chainIterator->valid();
    }
}
