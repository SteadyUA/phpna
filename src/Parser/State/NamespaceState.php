<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class NamespaceState extends State
{
    public function read(Reader $reader): ?string
    {
        $seq = $reader->readTo(';', '{');

        return '\\' . $seq->toString() . '\\';
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_NAMESPACE)) {
            return $this;
        }

        return $this->parent();
    }
}

