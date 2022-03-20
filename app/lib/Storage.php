<?php

namespace app\lib;


class Storage {
  private $location;
  public static function putFileAs(string $location, ?string $nameFile = null, int $maxSize = 2000000): ?string {
    if(trim($_FILES['image']['name']) == ""){
      return null;
    }
    $name = $_FILES['image']['name'];
    $error = $_FILES['image']['error'];
    $size = $_FILES['image']['size'];
    $tmp = $_FILES['image']['tmp_name'];
    if ($error === 4) {
      throw new \Exception("Image not uploaded");
    }
    if ($size > $maxSize) {
      throw new \Exception("Image size exceeds 2MB ");
    }
    $validExtension = ['png', 'jpg', 'jpeg'];
    $getImageExtension = explode('.', $name);
    $getImageExtension = strtolower(end($getImageExtension));
    if (!in_array($getImageExtension, $validExtension)) {
      throw new \Exception("Image not valid");
    }

    if (is_null($nameFile)) {
      $nameFile = microtime() . '_' . uniqid() . '.' . $getImageExtension;
    } else {
      $nameFile = $nameFile . "." . $getImageExtension;
    }
    move_uploaded_file($tmp, path($location) . "/$nameFile");
    return $nameFile;
  }

  public static function delete($path, $file): bool {
    if (file_exists(path() . $path . '/' . $file)) {
      unlink(path() . $path . '/' . $file);
      return true;
    }
    return false;
  }
}
