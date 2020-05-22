<?php

include __DIR__ . '/../autoload.php';

use SteadyUa\NsAnalyzer\Parser\{Parser, Reader, Tokenizer};
use SteadyUa\NsAnalyzer\Parser\State\GlobalScopeState;

set_time_limit(2);

foreach (glob(__DIR__ . '/case/*.php') as $fileName) {
    $testCases = include $fileName;
    foreach ($testCases as [$phpCode, $expected]) {
        $res = runTest($phpCode, $expected);
        if (!$res) {
            echo "File: {$fileName}\n\n";
            exit(1);
        }
    }
}
exit(0);

function runTest($phpCode, $expected) {
    $tokenizer = new Tokenizer();
    $reader = new Reader($tokenizer->parse($phpCode));
    $parser = new Parser($reader, new GlobalScopeState());
    $result = [];
    foreach ($parser->processor() as $name) {
        $result[] = $name;
    }
    if ($result != $expected) {
        echo "Failed: {$phpCode}\n";
        echo "Expected: " . implode(', ', $expected) . "\n";
        echo "Result: " . implode(', ', $result) . "\n";
        return false;
    }
    return true;
}
