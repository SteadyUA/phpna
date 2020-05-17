<?php
return [
[
    '<?php
/**
 * @var Foo\Bar $obj
 */
$obj = new Foo\Bar();
    ', ['Foo\Bar', 'Foo\Bar']
],
[
    '<?php
/**
 * @param \Foo\Bar[] $bar
 */
function test($bar) { }
    ', ['\Foo\Bar']
],
[
    '<?php
/**
 * @return Foo\Bar|Foo\Baz&\Iterator $bar
 */
function test() { }
    ', ['Foo\Bar','Foo\Baz','\Iterator']
],
[
    '<?php
/**
 * @return (string|int)[] $bar
 */
function test() { }
    ', ['string','int']
],
[
    '<?php
/**
 * @param \Foo\Bar1 $left
 * @param Foo\Bar2&Countable $right
 * @return \Foo\Baz $bar
 */
function test($left, $right) { }
    ', ['\Foo\Bar1', 'Foo\Bar2', 'Countable', '\Foo\Baz']
],
[
    '<?php
function main() {
    /**
     * @var Foo\Bar $obj
     */
    /**
     * @return (string|int)[] $bar
     */
    $obj = new Foo\Bar();
    $f = function () { };
    new \Foo();
}
    ', ['Foo\Bar', 'string', 'int', 'Foo\Bar',  '\Foo']
],
];
