<?php
return ['case' => [
    ['<?php
class Foo {
    function method1(): int {}
    public function method2() :?string { }
    public function method3() :\Foo\Bar
    { }
    public function method3() :?\Bar
    { }
    public function method4() :Foo\Bar {
    }
    public function method4() :?Foo\Baz {}
}
?>', ['int', 'string', '\Foo\Bar', '\Bar', 'Foo\Bar', 'Foo\Baz']],
]];
