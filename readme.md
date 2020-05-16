## About
PHP Namespace Analyzer `phpna`.
A utility for detecting dependencies on namespaces not described in the composer.json.

## Installation
You can download the source and create a link.
```
chmod +x ./bin/phpna
ln -s ./bin/phpna ~/bin/phpna
```

## Getting Started
- Go to the directory with the file `composer.json`
- Make sure the file `composer.lock` exists. Otherwise, run the command `composer install`
- To check files run the `phpna`

## Covered cases
```
namespace Foo\Bar;
use Foo\Bar; // and variations
new \Foo\Bar();
\Foo\Bar::Baz(); // static methods/variables/constants
interface extends \Foo\Bar, \Baz
interface { const = \Foo\Bar::Baz; }
class extends \Foo\Bar
class implements \Foo\Bar, \Baz
class { use \Foo\Bar; }
class { const = \Foo\Bar::Baz; }
class { $prop = \Foo\Bar::Baz; }
class { public \Foo\Bar $prop; }
trait { $prop = \Foo\Bar::Baz; }
trait { public \Foo\Bar $prop; }
function(\Foo\Bar $bar)
function($bar = \Foo\Bar::Baz)
function(): \Foo\Baz
```


