<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class ValueState extends State
{
    private $quoteInc = '';
    private $quoteDec = '';
    private $quoteCount;

    private $stopDef;

    public function __construct(State $parent, $stopDef = ';')
    {
        $this->quoteCount = 0;
        parent::__construct($parent);
        $this->stopDef = $stopDef;
        if ($stopDef == ')') {
            $this->quoteInc = '(';
            $this->quoteDec = ')';
        } elseif ($stopDef == ']') {
            $this->quoteInc = '[';
            $this->quoteDec = ']';
        } elseif ($stopDef == '}') {
            $this->quoteInc = '{';
            $this->quoteDec = '}';
        }
    }

    public function init(Reader $reader)
    {
        $token = $reader->current();
        if ($token->eq($this->quoteInc)) {
            $this->quoteCount ++;
        }
    }

    public function read(Reader $reader): ?string
    {
        $token = $reader->next();
        if ($this->quoteInc !== '') {
            switch ($token->text()) {
                case $this->quoteInc:
                    $this->quoteCount ++;
                    return null;

                case $this->quoteDec:
                    $this->quoteCount --;
                    return null;
            }
        }
        switch ($token->code()) {
            case T_CURLY_OPEN:
                if ($this->quoteInc == '{') {
                    $this->quoteCount ++;
                }
                break;

            case T_NEW:
                $nameSeq = $reader->matchRight(T_NS_SEPARATOR, T_STRING);
                if (!$nameSeq->isEmpty()) {
                    $reader->move($nameSeq->count());
                    return $nameSeq->toString();
                }
                break;

            case T_PAAMAYIM_NEKUDOTAYIM:
                $nameSeq = $reader->matchLeft(T_NS_SEPARATOR, T_STRING);
                return $nameSeq->toString();
        }

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq($this->stopDef) && $this->quoteCount == 0) {
            $reader->next();
            return $this->parent();
        }

        switch ($reader->current()->code()) {
            case T_FUNCTION:
                return new FunctionState($this);

            case T_CLASS:
                if ($reader->left(1)->code() !== T_PAAMAYIM_NEKUDOTAYIM) {
                    return new ClassState($this);
                }
                break;

            case T_DOC_COMMENT:
                return new DocCommentState($reader->current()->text(), $this);
        }

        return $this;
    }
}
