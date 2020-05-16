<?php
return [
    ['<?php
class Foo {
    function method1($prop1, \Foo $prop2): int;
    public function method2(string $prop1, \Foo\Bar ... $prop2) { }
    abstract function method3(array $prop = [\Bar::TYPE1, Foo\Bar::class]);
    public function method3(Foo\Baz ... $prop)
    { }
}
?>', ['\Foo', 'int', 'string', '\Foo\Bar', '\Bar', 'Foo\Bar', 'Foo\Baz']],

    ['<?php
function($prop1 = \Foo::class, $prop2 = [array([1]), Foo\Bar::BAZ]) {}
function method2(?string $prop1, ?\Foo\Bar $prop2 = null) { }
?>', ['\Foo', 'Foo\Bar', 'string', '\Foo\Bar', 'null']],
];
