<?php

namespace app\classes;

use app\lib\DB;
use app\lib\exception\ValidationException;
use app\lib\FlashMessage;
use app\lib\Storage;
use app\lib\Validate;
use app\traits\staticTrait;
use Exception;

class Users extends DB {
  use staticTrait;
  
  /**
   * view data crud
   * @return ?object data crud
   */
  public function _index() {
    $pageActive = 1;
    if (isset($_GET['page'])) {
      $pageActive = $_GET['page'];
    } else {
      $_GET['page'] = 1;
      $pageActive = $_GET['page'];
    }
    $limit = 1;
    if (isset($_GET['keyword'])) {
      $request = '%' . $_GET['keyword'] . '%';
      $num = $this->table('users')->where("name", "LIKE", $request)->num_rows();
    } else {
      $num = $this->table('users')->num_rows();
    }

    $offs = $pageActive - 1;
    $offset = $offs * $limit;
    $lenPage = ceil($num / $limit);
    $GLOBALS['lenPage'] = $lenPage;
    return $this->table('users')->limit($limit)->offset($offset)->getList();
  }

  /** 
   * create CRUD
   * @param array $request to input form data
   */
  public function _create($request): void {
    try {
      Validate::validate($request + $_FILES, [
        "name" => "required|string|max:100",
        "password" => "required|string|max:100",
        "email" => "required|email|string|max:100",
        "image" => "image"
      ]);
      $image = Storage::putFileAs("image");
    } catch (ValidationException | Exception $th) {
      FlashMessage::setFlash("failed", "{$th->getMessage()}");
      return;
    }
    $username = htmlspecialchars($request['name']);
    $password = password_hash(htmlspecialchars($request['password']), PASSWORD_DEFAULT);
    $email = htmlspecialchars($request['email']);
    $this->table('users')->insert('name,password,email,image', 'ssss', $username, $password, $email, $image);
    FlashMessage::setFlash("success", "Success create data");
  }

  /** 
   * update crud
   * @param array $request to input form data
   */
  public function _edit($request): void {
    try {
      Validate::validate($request + $_FILES, [
        "name" => "required|string|max:100",
        "email" => "required|email|string|max:100",
      ]);
      $image = Storage::putFileAs("image");
    } catch (ValidationException | Exception $th) {
      FlashMessage::setFlash("failed", "{$th->getMessage()}");
      return;
    }
    $id = htmlspecialchars($_POST['id_user']);
    $data = $this->table('users')->where('id', '=', $id)->getOne();
    $username = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    if (is_null($image)) {
      $image = $data->image;
    } else {
      Storage::delete("image", $data->image);
    }
    $update = $this->table("users")->update([
      "name" => $username,
      "email" => $email,
      "image" => $image,
    ], 'sssi', $id);
    if ($update > 0) {
      FlashMessage::setFlash('success', "Success");
    } else {
      FlashMessage::setFlash('failed', "Failed");
    }
  }

  /**
   * delete crud
   * @param int $id id to delete
   */
  public function _delete(int $id): void {
    $user = $this->table('users')->where('id', '=', $id)->getOne();
    if (!is_null($user)) {
      Storage::delete("image", $user->image);
      $delete = $this->table('users')->destroy($id);
      if ($delete > 0)
        FlashMessage::setFlash('success', "Sucess");
      else
        FlashMessage::setFlash('failed', "Failed");
    } else {
      FlashMessage::setFlash('failed', "Failed");
    }
  }

  /** 
   * search data from CRUD
   * @param string $request string to search
   * @return ?object return object data or null
    */
  public function _search($request): ?object {
    $request = "%$request%";
    $result = $this->table('users')->where('name', 'LIKE', $request)->getList();
    return $result;
  }
}
