[![Build Status](https://travis-ci.org/c4rl/pfunk.svg?branch=master)](https://travis-ci.org/c4rl/pfunk)

# Closures to methods; methods to closures.

Two traits are provided to give some functional magic to PHP classes.

## MethodsToClosures

The `MethodsToClosures` trait allows class methods to be accessed as closure
properties. The `$this` keyword is fully bound in the closure.

```php
<?php
use Pfunk\MethodsToClosures;

class Greeter {
  use MethodsToClosures;

  private $message = 'howdy %s';

  public function sayHowdy($name) {
    return sprintf($this->message, $name);
  }

}

$demo = new Greeter();
// Method is accessible as closure.
$greeter = $demo->sayHowdy;
// Returns "howdy carlos".
$greeter('carlos');
```

## Closures to methods

The `ClosuresToMethods` trait allows conversion of closure properties to be
accessed as methods. The `$this` keyword is fully bound in the closure.

```php
<?php
use Pfunk\ClosuresToMethods;

class OpenGreeter {
  use ClosuresToMethods;
}

$demo = new OpenGreeter();

// Closure is added as property, will be available as method.
$demo->whatUp = function ($name) {
  return sprintf('what up %s', $name);
};

// Returns "what up carlos"
$demo->whatUp('carlos');
```

### Danger! 

When using `ClosuresToMethods` because closures are fully-bound to `$this`,
it means that `protected` and `private` elements are accessible to the closure.

```php
<?php
use Pfunk\ClosuresToMethods;

class Danger {
  use ClosuresToMethods;

  private $do_not_touch = 'special value';

  public function getSpecialValue() {
    return $this->do_not_touch;
  }
}

$dangerous = new Danger();
// Returns "special value".
var_dump($dangerous->getSpecialValue());

// Closure can mutate private members.
$dangerous->changeIt = function () {
  $this->do_not_touch = 'scary value';
};
$dangerous->changeIt();

// Returns "scary value".
var_dump($dangerous->getSpecialValue());
```

This is generally considered a feature not a bug, but use caution, please :).
