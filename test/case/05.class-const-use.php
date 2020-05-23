<?php
return ['case' => [
    ['<?php
class Foo {
    const TYPE1 = 1;
    const TYPE2 = Bar::ONE;
    private const TYPE4 = \Foo\Bar::class;
    protected const TYPE3 = [\Foo::CONST];
}
?>', ['Bar', '\Foo\Bar', '\Foo']],

    ['<?php
class Foo {
    use Bar, \Foo\Bar;
    use \Foo {
        name as MyName;
    }
    use \Baz;
}
?>', ['Bar', '\Foo\Bar', '\Foo', '\Baz']],
]];
