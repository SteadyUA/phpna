<?php
return ['case' => [
    ['<?php
use Test2\Foo\Bar,
    \Test2\Bar;
use Test3\Foo as Test3Foo;
?>', ['\Test2\Foo\Bar', '\Test2\Bar', '\Test3\Foo']],

    ['<?php
use function str_replace as strReplace;
use function Test4\my_function as myFunction;
use function \Test5\my_function;
?>', ['\str_replace', '\Test4\my_function', '\Test5\my_function']],

    ['<?php
use CodeParser\{Parser, Foo\Reader};
use function CodeParser\{
    my_function as myFunction,
    Foo\Bar
};
?>', ['\CodeParser\Parser', '\CodeParser\Foo\Reader', '\CodeParser\my_function', '\CodeParser\Foo\Bar']],
]];
