<?php
define("BASE_URL",'http://localhost/php-oop-simple/assets/');
/**
 * get file from asset
 * @param ?string $path location 
 */
function asset(?string $path = null): string {
  $asset = is_null($path) ? BASE_URL : BASE_URL . $path;
  return $asset;
}

/**
 * path assets
 * @param ?string $path location
 */
function path(?string $path = null): string {
  $path = is_null($path) ? getcwd().'/assets/' : getcwd() ."/assets/". $path;
  return $path;
}