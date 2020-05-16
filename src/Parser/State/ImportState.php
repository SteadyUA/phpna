<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class ImportState extends State
{
    private $inList = false;
    private $prefix = '';

    public function init(Reader $reader)
    {
        $this->inList = false;
        $this->prefix = '';
        if ($reader->right(1)->eq(T_FUNCTION)) {
            $reader->next();
        }
    }

    protected function readList(Reader $reader)
    {
        $seq = $reader->readTo(T_AS, ',', '}');
        if ($reader->current()->eq(T_AS)) {
            $reader->readTo(',', ';', '}');
        }
        if ($reader->current()->eq('}')) {
            $reader->next();
        }

        return $this->prefix . $seq->toString();
    }

    public function read(Reader $reader): ?string
    {
        if ($this->inList) {
            return $this->readList($reader);
        }
        $nameSeq = $reader->readTo(T_AS, ',', ';', '{');
        $separator = '';
        if ($nameSeq->at(0)->eq(T_NS_SEPARATOR) == false) {
            $separator = '\\';
        }
        if ($reader->current()->eq('{')) {
            $this->inList = true;
            $this->prefix = $separator . $nameSeq->toString();

            return $this->readList($reader);
        }
        if ($reader->current()->eq(T_AS)) {
            $reader->readTo(',', ';', '}');
        }

        return $separator . $nameSeq->toString();
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_USE)) {
            return $this;
        }
        if ($reader->current()->eq(';')) {
            return $this->parent();
        }

        return $this;
    }
}
