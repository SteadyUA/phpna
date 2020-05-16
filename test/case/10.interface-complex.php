<?php
return [
    ['<?php
interface Foo {
    const TYPE1 = 1;
    const TYPE2 = Bar::ONE;
    private const TYPE4 = \Foo\Bar::class;
    protected const TYPE3 = [\Foo::CONST];
}
?>', ['Bar', '\Foo\Bar', '\Foo']],

    ['<?php
interface Foo {
    function method1(): int;
    
    public function method2() : ?string;

    private const TYPE4 = \Foo\Bar::class;

    public function method4($prop1, \Bar $prop2) :Foo\Bar;

    protected const TYPE3 = [\Foo::CONST];
}
?>', ['int', 'string', '\Foo\Bar', '\Bar', 'Foo\Bar', '\Foo']],
];
