<?php
return ['case' => [
    ['<?php
trait Foo { }
?>', []],
    ['<?php
trait Foo {
    protected $prop = Bar::VALUE;
}
?>', ['Bar']],
    ['<?php
trait Foo extends Baz, \Foo\Quz {
    function method1(): Baz;
    private $prop = \Foo\Quz::TYPE;
    public function method4($prop1, \Bar $prop2) :Foo\Bar;
}
?>', ['Baz', '\Foo\Quz', '\Bar', 'Foo\Bar']],
]];
