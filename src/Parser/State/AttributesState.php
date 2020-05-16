<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class AttributesState extends State
{
    public function read(Reader $reader): ?string
    {
        $typeSeq = $reader->matchRight('?', T_NS_SEPARATOR, T_STRING);
        $reader->readTo(',', ')', '=');

        if (!$typeSeq->isEmpty()) {
            if ($typeSeq->at(0)->eq('?')) {
                $typeSeq = $typeSeq->slice(1);
            }

            return $typeSeq->toString();
        }

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(')')) {
            $reader->next();
            return $this->parent();
        }

        if ($reader->current()->eq('=')) {
            if ($reader->right(1)->code() == T_ARRAY) {
                $reader->move(2);

                return new ValueState($this, ')');
            }
            if ($reader->right(1)->text() == '[') {
                $reader->next();

                return new ValueState($this, ']');
            }
        }

        return $this;
    }
}
