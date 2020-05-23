<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class FnState extends State
{
    public function read(Reader $reader): ?string
    {
        if ($reader->current()->eq(':')) {
            $typeSeq = $reader->readTo(T_DOUBLE_ARROW);
            if ($typeSeq->at(0)->eq('?')) {
                $typeSeq = $typeSeq->slice(1);
            }

            return $typeSeq->toString();
        }
        $reader->readTo('(');

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_DOUBLE_ARROW)) {
            $reader->next();
            return $this->parent();
        }
        if ($reader->current()->eq(T_FN)) {
            return $this;
        }
        if ($reader->current()->eq(':')) {
            return $this;
        }
        if ($reader->current()->eq('(')) {
            return new AttributesState($this);
        }

        return $this->parent();
    }
}
