<?php

namespace Pfunk;

/**
 * Class ClosuresToMethods.
 *
 * @package Pfunk
 */
trait ClosuresToMethods {

  /**
   * Dynamic setter that will bind closures to instance.
   *
   * @param string $name
   *   Property name.
   * @param mixed $value
   *   Property value.
   */
  public function __set($name, $value) {
    if ($value instanceof \Closure) {
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
    throw new \BadMethodCallException();
  }

}
