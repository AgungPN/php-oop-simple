<?php

spl_autoload_register(function ($class) {
    $class = explode("\\", $class);
    $class = end($class);

    if (file_exists($f = __DIR__."/lib/".$class.".php")) {
        require_once $f;
    }

    if (file_exists($f = __DIR__."/classes/".$class.".php")) {
        require_once $f;
    }

    if(file_exists($f = __DIR__."/traits/".$class.".php")){
      require_once $f;
    }
  });
  require_once __DIR__."/helpers/helpers.php";
  require_once __DIR__."/../system.php";
  require_once __DIR__."/../index.php";
