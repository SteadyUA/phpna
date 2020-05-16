<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class PropertyState extends State
{
    private $type;

    public function init(Reader $reader)
    {
        // 7.4 type specification
        $type = [];
        $typeSeq = $reader->matchLeft(T_NS_SEPARATOR, T_STRING, '?');
        if (!$typeSeq->isEmpty()) {
            if ($typeSeq->at(0)->eq('?')) {
                $typeSeq = $typeSeq->slice(1);
            }
            $type[] = $typeSeq->toString();
        }
        $this->type = array_unique($type);
    }

    public function read(Reader $reader): ?string
    {
        if ($this->type) {
            return array_shift($this->type);
        }
        $reader->readTo('=', ';');

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_VARIABLE)) {
            return $this;
        }
        if ($reader->current()->eq('=')) {
            return new ValueState($this);
        }

        return $this->parent();
    }
}
