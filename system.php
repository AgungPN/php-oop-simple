<?php
session_start();

use app\classes\Users;
use app\lib\FlashMessage;

$users = Users::index();
$lenPage = $GLOBALS['lenPage'];

if (isset($_POST['add'])) {
  Users::create($_POST);
}

if (isset($_POST['update'])) {
  Users::edit($_POST);
}

if (isset($_POST['delete'])) {
  Users::delete($_POST['id_user']);
}

if (isset($_GET['search'])) {
  $users = Users::search($_GET['keyword']);
}

FlashMessage::message();