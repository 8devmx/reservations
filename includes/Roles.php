<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

if ($post) {
  $roles = new Roles();
  switch ($post['action']) {
    case 'showData':
      $roles->getAllData();
      break;
    case 'insert':
      $roles->insertData($post);
      break;
    case 'delete':
      $roles->deleteData($post["id"]);
      break;
    case 'selectOne':
      $roles->getOneData($post);
      break;
    case 'update':
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
    $data = [];
    $result = $mysqli->query($query);
    while ($row = $result->fetch_object()) {
      $data[] = $row;
    }
    echo json_encode($data);
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

    $query = "update roles set name = '$name', active = '$status' where id = $id";

    global $mysqli;
    $mysqli->query($query);

    $response = [
      "message" => "No se pudo editar el registro en la base de datos",
      "status" => 1
    ];
    if ($mysqli->affected_rows > 0) {
      $response = [
        "message" => "Se editó correctamente el Rol de " . $name,
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
    $query = "INSERT INTO roles (name, active) VALUES ('$nombre', '$status')";
    $mysqli->query($query);

    $response = [
      "message" => "No se pudo almacenar el registro en la base de datos",
      "status" => 1
    ];
    if ($mysqli->insert_id != 0) {
      $response = [
        "message" => "Se registró correctamente el Rol de " . $nombre,
        "status" => 2
      ];
    }
    echo json_encode($response);
  }

  public function deleteData($id)
  {
    global $mysqli;
    $query = "DELETE FROM roles WHERE id = $id";
    $mysqli->query($query);
    $response = [
      "message" => "No se pudo eliminar el registro",
      "status" => 0
    ];
    if ($mysqli->affected_rows > 0) {
      $response = [
        "message" => "Se eliminó correctamente el Rol",
        "status" => 1
      ];
    }
    echo json_encode($response);
  }
}
