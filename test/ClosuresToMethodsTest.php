<?php

use Pfunk\ClosuresToMethods;
use PHPUnit\Framework\TestCase;

/**
 * Class ClosuresToMethodsTest.
 */
class ClosuresToMethodsTest extends TestCase {

  /**
   * Tests converting a closure property to a method.
   */
  public function testClosureToMethod() {

    $demo = new class {
      use ClosuresToMethods;
    };

    $demo->foo = function () {
      return 4321;
    };

    $this->assertEquals(4321, $demo->foo());
  }

}
