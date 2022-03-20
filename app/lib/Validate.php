<?php

namespace app\lib;

class Validate {
  protected $validasiData;
  public static function validate($data, $validate) {
    $self = new self;
    $self->validasiData = $validate;
    foreach ($validate as $key => $value) {
      $splits = explode("|", $value);
      foreach ($splits as $split) {
        $tes = strpos($split,'max:100');
          var_dump($tes);
        if ($tes>0) {
          var_dump("Hello World");
          $self->max(end(explode(":",$split)),$key);
        } else {
          # code...
        }
        
      }
    }
    die;
  }
  public function max(int $maxLength, $key)
  {
    var_dump("Length: {$maxLength}, Key: {$key}");die;
  }
}
