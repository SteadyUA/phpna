<?php

namespace SteadyUa\NsAnalyzer\Parser;

use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;
use RuntimeException;
use SeekableIterator;

class Sequence implements IteratorAggregate, Countable
{
    /**
     * @var Token[]
     */
    protected $token = [];
    protected $length = 0;

    public function __construct(iterable $source = [])
    {
        $this->addAll($source);
    }

    public function addAll(iterable $source)
    {
        foreach ($source as $token) {
            $this->add($token);
        }
    }

    public function at(int $index): Token
    {
        if (!isset($this->token[$index])) {
            throw new RuntimeException('Out of boundaries.');
        }

        return $this->token[$index];
    }

    public function slice(int $offset, int $length = null)
    {
         if ($offset < 0) {
             $offset += $this->count();
         }
         if (null === $length) {
             $length = $this->count() - $offset;
         }
         $seq = new Sequence();
         for ($i = $offset; $i < count($this->token) && $seq->count() < $length; $i ++) {
             $seq->add($this->token[$i]);
         }

         return $seq;
    }

    public function add(Token $token)
    {
        $this->token[] = $token;
        $this->length ++;
    }

    /**
     * @return Iterator&SeekableIterator|Token[]
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->token);
    }

    public function toString(): string
    {
        $result = '';
        foreach ($this->token as $token) {
            $result .= $token->text();
        }

        return $result;
    }

    public function count()
    {
        return $this->length;
    }

    public function isEmpty()
    {
        return $this->length == 0;
    }
}
