<?php

trait PfunkTrait {

  /**
   * Delegate methods to property accessors via closures.
   *
   * @param string $name
   *   Name of method.
   *
   * @return \Closure
   *   Method closure fully bound to object instance.
   */
  public function __get($name) {
    if (method_exists($this, $name)) {
      $instance = $this;
      $closure = function (...$vars) use ($instance, $name) {
        return $instance->{$name}($vars);
      };
      return $closure->bindTo($instance, $instance);
    }
    throw new BadMethodCallException();
  }

  /**
   * Dynamic setter that will bind closures to instance.
   *
   * @param string $name
   *   Property name.
   * @param mixed $value
   *   Property value.
   */
  public function __set($name, $value) {
    if ($value instanceof Closure) {
      $this->$name = $value->bindTo($this, $this);
    }
    else {
      $this->$name = $value;
    }
  }

  /**
   * Call any set closures.
   *
   * @param string $name
   *   Name of set closure.
   * @param array $args
   *   Arguments to pass to set closure.
   *
   * @return mixed
   *   Result from set closure.
   */
  public function __call($name, array $args) {
    if (is_callable($this->$name)) {
      $closure = $this->$name;
      return $closure(...$args);
    }
    throw new BadMethodCallException();
  }

}

class PapaSmurf {
  use PfunkTrait;

  private $stuff = 'howdy';

  public function foo() {
    var_dump($this->stuff);
  }

}

$pops = new PapaSmurf();

$bro = $pops->foo;

$bro();

$pops->bar = function () {
  var_dump($this->stuff . ' again');
};

$pops->bar();
