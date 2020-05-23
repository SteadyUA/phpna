<?php
return ['case' => [
    ['<?php
class Foo {
    function method1(array $prop1 = [], \Foo $prop2): int {
        $b = function test (string $prop1, \Foo\Bar ... $prop2) {
            return \Bar::$static[\Baz::TYPE];
        };
        new Foo\Bar;
    }
}
?>', ['\Foo', 'int', 'string', '\Foo\Bar', '\Bar', '\Baz', 'Foo\Bar']],

    ['<?php
$b = new class extends \Foo {
    function method1($prop1, $prop2): int {
        $b = function test (string $prop1, \Foo\Bar ... $prop2) {
            return \Bar::TYPE1;
        };
        new Foo\Bar;
    }
};
?>', ['\Foo', 'int', 'string', '\Foo\Bar', '\Bar', 'Foo\Bar']],

]];
