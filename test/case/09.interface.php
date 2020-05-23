<?php
return ['case' => [
    ['<?php
interface Foo { }
?>', []],
    ['<?php
interface Foo extends Bar { }
?>', ['Bar']],
    ['<?php
interface Foo extends Baz, \Foo\Quz { }
?>', ['Baz', '\Foo\Quz']],
    ['<?php
interface Foo { }
final class Foo extends Bar { }
interface Foo extends Baz { }
?>', ['Bar', 'Baz']],
]];
