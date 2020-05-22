<?php

namespace SteadyUa\NsAnalyzer\Parser\State;

use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\State;

class DocCommentState extends State
{
    private $list = [];

    public function __construct($text, State $parent = null)
    {
        parent::__construct($parent);
        $list = [];
        if (preg_match_all('/@(var|return|param|throws)\s([^\s\$]+)/i', $text, $match) > 0) {
            foreach ($match[2] as $typeDefinition) {
                if (preg_match_all('/([\w\d\\\]+)/i', $typeDefinition, $result) > 0) {
                    $list = array_merge($list, $result[1]);
                }
            }
        }
        $this->list = array_unique($list);
    }

    public function init(Reader $reader)
    {
        if (empty($this->list)) {
            $reader->next();
        }
    }

    public function read(Reader $reader): ?string
    {
        if (empty($this->list)) {
            return null;
        }

        if (count($this->list) == 1) {
            $reader->next();
        }

        return array_shift($this->list);
    }

    public function suggestState(Reader $reader): ?State
    {
        if ($this->list) {
            return $this;
        }

        return $this->parent();
    }
}
