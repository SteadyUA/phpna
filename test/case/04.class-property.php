<?php
return ['case' => [
    ['<?php
class Foo {
    $prop1;
    $prop2 = Bar::ONE;
    static $prop3 = [\Foo::CONST];
    private $prop4 = \Foo\Bar::class;
}
?>', ['Bar', '\Foo', '\Foo\Bar']],

    ['<?php
class Foo {
    public Bar $prop1;
    \Type\Foo $prop2;
    static array $prop3 = [\Foo::CONST];
    private string $prop4 = \Foo\Bar::class;
}
?>', ['Bar', '\Type\Foo', '\Foo', 'string', '\Foo\Bar']],

    ['<?php
class Foo {
    public ?string $prop1;
    protected ?Bar $prop2;
    private ?\Foo\Bar $prop3;
}
?>', ['string', 'Bar', '\Foo\Bar']],
]];
