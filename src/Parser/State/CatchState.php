<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class CatchState extends State
{
    private $inCatch = true;

    public function init(Reader $reader)
    {
        $reader->readTo('(');
    }

    public function read(Reader $reader): ?string
    {
        $typeSeq = $reader->readTo(T_VARIABLE, ')', '|');
        if ($reader->current()->text() == ')') {
            $reader->next();
            $this->inCatch = false;
            return null;
        }

        return $typeSeq->toString();
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($this->inCatch) {
            return $this;
        }

        return $this->parent();
    }
}
