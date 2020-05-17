<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class InterfaceState extends State
{
    private $inExtends;

    public function init(Reader $reader)
    {
        $this->inExtends = false;
    }

    public function read(Reader $reader): ?string
    {
        if ($reader->current()->eq(T_INTERFACE)) {
            $reader->readTo(T_EXTENDS, '{');
        }
        if ($reader->current()->eq(T_EXTENDS)) {
            $this->inExtends = true;
        }
        if ($this->inExtends) {
            $extends = $reader->readTo(',', '{');
            $this->inExtends = $reader->current()->eq(',');

            return $extends->toString();
        }

        $reader->readTo(T_DOC_COMMENT, T_FUNCTION, T_CONST, '}');

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_INTERFACE)) {
            return $this;
        }

        if ($reader->current()->eq('}')) {
            return $this->parent();
        }

        switch ($reader->current()->code()) {
            case T_DOC_COMMENT:
                return new DocCommentState($reader->current()->text(), $this);

            case T_CONST:
                return new ConstState($this);

            case T_FUNCTION:
                return new FunctionState($this);
        }

        return $this;
    }
}
