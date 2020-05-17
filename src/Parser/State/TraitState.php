<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class TraitState extends State
{
    public function init(Reader $reader)
    {
        if ($reader->current()->eq(T_TRAIT)) {
            $reader->readTo('{');
        }
    }

    public function read(Reader $reader): ?string
    {
        $reader->readTo(T_DOC_COMMENT, T_FUNCTION, T_VARIABLE, '}');

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_TRAIT)) {
            return $this;
        }

        if ($reader->current()->eq('}')) {
            return $this->parent();
        }

        switch ($reader->current()->code()) {
            case T_DOC_COMMENT:
                return new DocCommentState($reader->current()->text(), $this);

            case T_VARIABLE:
                return new PropertyState($this);

            case T_FUNCTION:
                return new FunctionState($this);
        }

        return $this;
    }
}
