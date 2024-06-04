<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';
if ($post) {
  switch ($post['action']) {
    case 'insert':
      $roles = new Roles();
      $roles->insertData($post);
      break;
    case 'delete':
      $roles = new Roles();
      $roles->deleteData($post);
      break;
    case 'selectOne':
      $roles = new Roles();
      $roles->getOneData($post);
      break;
    case 'update':
      $roles = new Roles();
      $roles->updateData($post);
      break;
  }
}
class Roles
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT * FROM roles";
    return $mysqli->query($query);
  }

  public function getOneData($post)
  {
    $id = $post['id'];
    global $mysqli;
    $query = "SELECT * FROM roles where id = $id";
    $result = $mysqli->query($query);
    echo json_encode($result->fetch_object());
  }

  public function updateData($post)
  {
    $name = $post['name'];
    $status = $post['status'];
    $id = $post['id'];

    $query = "update users set name = '$name', active = '$status' where id = $id";

    global $mysqli;
    $mysqli->query($query);

    $response = [
      "message" => "No se pudo editar el registro en la base de datos",
      "status" => 1
    ];
    if ($mysqli->affected_rows > 0) {
      $response = [
        "message" => "Se editó correctamente el usuario de " . $name,
        "status" => 2
      ];
    }
    echo json_encode($response);
  }

  public function insertData($data)
  {
    global $mysqli;
    $nombre = $data['name'];
    $status = $data['status'];
    $query =  "INSERT INTO roles (name, active) VALUES ('$nombre', '$status')";
    $mysqli->query($query);
    $response = [
      "message" => "No se pudo almacenar el registro en la base de datos",
      "status" => 0
    ];
    if ($mysqli->insert_id != 0) {
      $response = [
        "message" => "Se registró correctamente el rol de " . $nombre,
        "status" => 1
      ];
    }
    echo json_encode($response);
  }
  
  {
    $id = $data['id'];
    global $mysqli;
    $query = "DELETE FROM roles where id =  $id";
    $response = [
      "message" => "No se pudo eliminar el registro en la base de datos",
      "status" => 0
    ];

    if ($mysqli->query($query)) {
      $response = [
        "message" => "Se ha eliminado el registro en la base de datos",
        "status" => 1
      ];
    }
    echo json_encode($response);
  }
}

if ($post && $post['action'] == 'insert') {
  $roles = new Roles();
  $roles->insertData($post);
}
