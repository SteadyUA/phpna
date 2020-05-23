<?php
return ['case' => [
[
    '<?php
class MyClass {
    /** @var Foo\Bar */
    public $obj;
    
    /**
     * @param \Foo\Bar $attr
     * @return \Foo\Baz $bar
     */
    function test($attr) {
        someCode();
    }
    
    /** @var int|null */
    public $prop2;
    
    /**
     * @return string $bar
     */
    function test2() {
        /** @var \stdClass $prop2*/
        $prop2;
    }
}
    ', ['Foo\Bar', '\Foo\Bar', '\Foo\Baz', 'int', 'null', 'string', '\stdClass']
],
[
    '<?php
trait MyTrait {
    /** @var Foo\Bar */
    public $obj;
    
    /**
     * @param \Foo\Bar $attr
     * @throws \Foo\Baz $bar
     */
    function test($attr) {
        someCode();
    }
    
    /** @var int|null */
    public $prop2;

    /**
     * empty and consecutive comments 
     */
    /**
     * @return string $bar
     */
    function test2() {
        /** @var \stdClass $prop2*/
        $prop2;
    }
}
    ', ['Foo\Bar', '\Foo\Bar', '\Foo\Baz', 'int', 'null', 'string', '\stdClass']
],
[
    '<?php
interface MyInterface {
    /**
     * @param \Foo\Bar $attr
     * @return \Foo\Baz $bar
     */
    function test($attr);
    
   /**
     * @return bool $bar
     */
    function method2();
}
    ', ['\Foo\Bar', '\Foo\Baz', 'bool']
],
]];
