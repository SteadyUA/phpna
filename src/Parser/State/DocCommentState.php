<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class DocCommentState extends State
{
    private $list = [];

    public function init(Reader $reader)
    {
        $list = [];
        $text = $reader->current()->text();
        if (preg_match('/@(var|return|param)\s([^\s\$]+)/i', $text, $match)
            && preg_match_all('/([\w\\\]+)/i', $match[2], $result) > 0
        ) {
            $list += $result[1];
        }

        $this->list = array_unique($list);
    }

    public function read(Reader $reader): ?string
    {
        if ($this->list) {
            return array_shift($this->list);
        }
        $reader->next();

        return null;
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($reader->current()->eq(T_DOC_COMMENT)) {
            return $this;
        }

        return $this->parent();
    }
}
