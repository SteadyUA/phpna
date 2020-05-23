<?php
return ['case' => [
    ['<?php
class Foo { }
?>', []],
    ['<?php
class Foo extends Bar { }
?>', ['Bar']],
    ['<?php
class Foo extends \Bar implements Baz, \Foo\Quz { }
?>', ['\Bar', 'Baz', '\Foo\Quz']],
    ['<?php
class Foo { }
final class Foo extends Bar { }
abstract class Foo extends \Bar implements Baz { }
?>', ['Bar', '\Bar', 'Baz']],
]];
