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
?>', ['\Foo', '\Bar', '\Test']],
];
