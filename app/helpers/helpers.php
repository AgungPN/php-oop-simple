<?php
define("BASE_URL",'http://localhost/php-oop-simple/assets/');
function asset(?string $path = null): string {
  $asset = is_null($path) ? BASE_URL : BASE_URL . $path;
  return $asset;
}

function path(?string $path = null): string {
  $path = is_null($path) ? getcwd().'/assets/' : getcwd() ."/assets/". $path;
  return $path;
}