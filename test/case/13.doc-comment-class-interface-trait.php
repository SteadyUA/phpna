<?php
// TODO: test cases
return [
[
    '<?php
class MyClass {
    /** @var Foo\Bar */
    public $obj;
    
    /**
     * @param \Foo\Bar $attr
     * @return \Foo\Baz $bar
     */
    function test($attr) { }
}
    ', ['Foo\Bar', '\Foo\Bar', '\Foo\Baz']
]
];
