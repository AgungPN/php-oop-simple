<?php
namespace app\traits;
trait staticTrait {
  public function __call($method, $args) {
    return $this->call($method, $args);
  }
  public static function __callStatic($method, $args) {
    return (new self)->call($method, $args);
  }
  private function call($method, $args) {
    if (!method_exists($this, '_' . $method)) 
      throw new \Exception("undefined method: $method");
    return $this->{'_' . $method}(...$args);
  }
}
