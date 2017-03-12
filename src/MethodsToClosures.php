<?php

namespace Pfunk;

/**
 * Trait MethodsToClosures.
 *
 * @package Pfunk
 */
trait MethodsToClosures {

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
    throw new \BadMethodCallException();
  }

}
