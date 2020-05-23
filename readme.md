## About
PHP Namespace Analyzer `phpna`.
A utility for detecting dependencies on namespaces not described in the composer.json.

## Installation
### Composer
If you use Composer, you can install `phpna` system-wide with the following command:

```
composer global require steady-ua/ns-analyzer
```

Make sure you have the composer bin dir in your PATH. The default value is `~/.composer/vendor/bin/`, but you can check the value that you need to use by running `composer global config bin-dir --absolute`.

Or include a dependency for `steady-ua/ns-analyzer` in your `composer.json` file.

```
composer require steady-ua/ns-analyzer --dev
```

You will then be able to run from the vendor bin directory:

```
./vendor/bin/phpna
```

### Git Clone
You can download the source and create a link.
```
git clone https://github.com/SteadyUA/phpna.git
cd phpna
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
catch (\FooException $ex)
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
/** @var \Foo\Bar */
/** @param \Foo\Bar */
/** @return \Foo\Bar */
/** @throw \Foo\Bar */
fn(\Foo\Bar $bar) =>
fn($foo) : \Foo\Bar =>
```


