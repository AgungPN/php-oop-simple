<?php

namespace app\lib;

use app\lib\exception\ValidationException;

class Validate {
  protected $validasiData;
  protected $messages = [
    "string" => "value :key not string",
    "email" => "value :key not email",
    "number" => "value :key not number",
    "image" => "value :key not image",
    "required" => "value :key required",
    "max" => "the length of the :key must be lower than :value",
  ];
  public static function validate(array $data, $validate) {
    $data = (object)$data;
    $self = new self;
    $self->validasiData = $data;

    foreach ($validate as $key => $value) {
      $splits = explode("|", $value);
      foreach ($splits as $split) {
        $explode = explode(":", $split);
        if (method_exists($self, $explode[0])) {
          if (count($explode) > 1) {
            $bool = call_user_func(array($self, $explode[0]), end($explode), $key);
            if (!$bool) {
              $message = str_replace(":value", end($explode), $self->messages[$key]);
              $message = str_replace(":key", "{$key}", $message);
              throw new ValidationException($message);
            }
          } else {
            $bool = call_user_func(array($self, $explode[0]), $key);
            if (!$bool) {
              $message = str_replace(":key", "{$key}", $self->messages[$key]);
              throw new ValidationException($message);
            }
          }
        } else {
          throw new \Exception("Method not found");
        }
      }
    }
  }
  public function max(int $maxLength, $key): bool {
    if (strlen($this->validasiData->$key) <= $maxLength)
      return true;
    return false;
  }
  public function string($key): bool {
    if (is_string($this->validasiData->$key))
      return true;
    return false;
  }
  public function email($key): bool {
    if (filter_var($this->validasiData->$key, FILTER_VALIDATE_EMAIL))
      return true;
    return false;
  }
  public function number($key): bool {
    if (is_numeric($this->validasiData->$key))
      return true;
    return false;
  }
  public function required($key): bool {
    if (trim($this->validasiData->$key) != "")
      return true;
    return false;
  }
  public function image($key): bool {
    if (trim($_FILES['' . $key]['name']) != "")
      return true;
    return false;
  }
}
