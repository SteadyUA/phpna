<?php

namespace SteadyUa\NsAnalyzer;

use AppendIterator;
use IteratorAggregate;
use IteratorIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;

class DirScanner implements IteratorAggregate
{
    private $iterator;

    public function __construct()
    {
        $this->iterator = new AppendIterator();
    }

    public function add(string $path)
    {
        $directory = new RecursiveDirectoryIterator($path);
        $recursive = new RecursiveIteratorIterator($directory);
        $this->iterator->append(
            $this->makeIterator(
                new RegexIterator($recursive, '/\.php$/i', RegexIterator::MATCH)
            )
        );
    }

    protected function makeIterator($iterator)
    {
        return new class ($iterator) extends IteratorIterator
        {
            public function key()
            {
                /** @var SplFileInfo $fileInfo */
                $fileInfo = parent::current();

                return $fileInfo->getPathname();
            }

            public function current()
            {
                $fileScanner = new FileScanner(parent::current());

                return $fileScanner->scan();
            }
        };
    }

    public function getIterator()
    {
        return $this->iterator;
    }
}
