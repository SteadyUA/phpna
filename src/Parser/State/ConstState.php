<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class ConstState extends State
{
    public function read(Reader $reader): ?string
    {
        $reader->readTo('=');

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_CONST)) {
            return $this;
        }

        if ($reader->current()->eq('=')) {
            return new ValueState($this);
        }

        return $this->parent();
    }
}
