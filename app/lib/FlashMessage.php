<?php

namespace app\lib;

class FlashMessage {
  public static function setFlash(string $type, string $message) {
    $_SESSION["flash"] = [
      "type" => $type,
      "message" => $message
    ];
  }
  public static function message() {
    if (isset($_SESSION['flash'])) {
      echo "<script>alert('{$_SESSION['flash']['message']}');document.location.href='index.php';</script>";
      unset($_SESSION['flash']);
    }
  }
}
