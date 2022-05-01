<?php
namespace app\traits;
trait staticTrait {
  /**
   * magic function for call method if not found
   * @param mixed $method name method
   * @param mixed $args arguments
   */
  public function __call($method, $args) {
    return $this->call($method, $args);
  }
  /**
   * magic function for call method static if not found
   * @param mixed $method name method
   * @param mixed $args arguments
   */
  public static function __callStatic($method, $args) {
    return (new self)->call($method, $args);
  }
  /**
   * mixed call function static/not
   * @param mixed $method name method
   * @param mixed $args arguments
   */
  private function call($method, $args) {
    if (!method_exists($this, '_' . $method)) 
      throw new \Exception("undefined method: $method");
    return $this->{'_' . $method}(...$args);
  }
}
