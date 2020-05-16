<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class UseTraitState extends State
{
    public function read(Reader $reader): ?string
    {
        $traitName = $reader->readTo(',', ';', '{');
        if ($reader->current()->eq('{')) {
            $reader->readTo('}');
        }
        return $traitName->toString();
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->code() == T_TRAIT) {
            return $this;
        }

        switch ($reader->current()->text()) {
            case '}';
            case ';';
                $reader->next();
                return $this->parent();
        }

        return $this;
    }
}
