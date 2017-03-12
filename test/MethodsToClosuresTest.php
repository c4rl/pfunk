<?php

use Pfunk\MethodsToClosures;
use PHPUnit\Framework\TestCase;

/**
 * Class MethodsToClosuresTest.
 */
class MethodsToClosuresTest extends TestCase {

  /**
   * Tests converting a method to a closure.
   */
  public function testMethodsToClosures() {

    $demo = new class {
      use MethodsToClosures;

      public function foo($plus) {
        return 234 + $plus;
      }

    };

    $closure = $demo->foo;

    $this->assertEquals(1234, $closure(1000));
  }

}
