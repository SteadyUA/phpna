<?php

namespace SteadyUa\NsAnalyzer;

use SplFileInfo;
use SteadyUa\NsAnalyzer\Parser\State\GlobalScopeState;
use SteadyUa\NsAnalyzer\Parser\Parser;
use SteadyUa\NsAnalyzer\Parser\Reader;
use SteadyUa\NsAnalyzer\Parser\Tokenizer;

class FileScanner
{
    /**
     * @var Parser
     */
    private $reader;

    public function __construct(SplFileInfo $fileInfo)
    {
        $file = $fileInfo->openFile('r');
        $this->reader = $this->makeParser($file->fread($file->getSize()));
    }

    public function scan(): array
    {
        $namespaceSet = [];
        foreach ($this->reader->processor() as $typeName) {
            if ($typeName[0] == '\\' && substr_count($typeName, '\\') > 1) {
                $namespaceSet[substr($typeName, 1)] = true;
            }
        }

        return array_keys($namespaceSet);
    }

    protected function makeParser(string $phpCode): Parser
    {
        $tokenizer = new Tokenizer();
        $reader = new Reader($tokenizer->parse($phpCode));

        return new Parser($reader, new GlobalScopeState());
    }
}
