<?php

require './vendor/autoload.php';

use Pfunk\ClosuresToMethods;
use Pfunk\MethodsToClosures;

class PapaSmurf {
  use MethodsToClosures;
  use ClosuresToMethods;

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
