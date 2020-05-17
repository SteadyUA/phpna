<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class ClassState extends State
{
    private $inImplements;

    public function init(Reader $reader)
    {
        $this->inImplements = false;
    }

    public function read(Reader $reader): ?string
    {
        if ($reader->current()->eq(T_CLASS)) {
            $reader->readTo(T_EXTENDS, T_IMPLEMENTS, '{');
            if ($reader->current()->eq(T_EXTENDS)) {
                return $reader->readTo(T_IMPLEMENTS, '{')->toString();
            }
        }
        if ($reader->current()->eq(T_IMPLEMENTS)) {
            $this->inImplements = true;
        }
        if ($this->inImplements) {
            $implement = $reader->readTo(',', '{');
            $this->inImplements = $reader->current()->eq(',');

            return $implement->toString();
        }

        $reader->readTo(T_DOC_COMMENT, T_FUNCTION, T_VARIABLE, T_CONST, T_USE, '}');

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_CLASS)) {
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

            case T_CONST:
                return new ConstState($this);

            case T_FUNCTION:
                return new FunctionState($this);

            case T_USE:
                return new UseTraitState($this);
        }

        return $this;
    }
}
