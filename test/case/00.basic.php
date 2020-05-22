<?php
return [
    ['<?php
$a = Test1::class;
echo \Test3::$variable;
new Test2\Name();
?>', ['Test1', '\Test3', 'Test2\Name']],

    ['<?php
\Foo::bar(\Bar::class);
new \Test;
class Foo {
    public function tst() {
        $a = $this::bar();
        $b = self::bar();
        return static::class;
    }
}
?>', ['\Foo', '\Bar', '\Test', '$this', 'self', 'static']],
];
