<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

if ($post) {
  $users = new User();
  switch ($post['action']) {
    case 'showData':
      $users->getAllData();
      break;
    case 'insert':
      $users->insertData($post);
      break;
    case 'delete':
      $users->deleteData($post["id"]);
      break;
    case 'selectOne':
      $users->getOneData($post);
      break;
    case 'update':
      $users->updateData($post);
      break;
  }
}

class User
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT users.id, users.name as name, users.email, users.phone, users.active, roles.name as rol FROM users LEFT JOIN roles on users.rol_id = roles.id";
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
    $query = "SELECT * FROM users where id = $id";
    $result = $mysqli->query($query);
    echo json_encode($result->fetch_object());
  }
  public function updateData($post)
  {
    $name = $post['name'];
    $email = $post['email'];
    $phone = $post['phone'];
    $rol = $post['rol'];
    $status = $post['status'];
    $id = $post['id'];

    $query = "update users set name = '$name', email = '$email', phone = '$phone', rol_id = '$rol', active = '$status' where id = $id";

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
    $email = $data['email'];
    $phone = $data['phone'];
    $rol = $data['rol'];
    $status = $data['status'];
    $query = "INSERT INTO users (name, email, phone, rol_id, active) VALUES ('$nombre', '$email', '$phone', '$rol', '$status')";
    $mysqli->query($query);

    $response = [
      "message" => "No se pudo almacenar el registro en la base de datos",
      "status" => 1
    ];
    if ($mysqli->insert_id != 0) {
      $response = [
        "message" => "Se registró correctamente el usuario de " . $nombre,
        "status" => 2
      ];
    }
    echo json_encode($response);
  }

  public function deleteData($id)
  {
    global $mysqli;
    $query = "DELETE FROM users WHERE id = $id";
    $mysqli->query($query);
    $response = [
      "message" => "No se pudo eliminar el registro",
      "status" => 0
    ];
    if ($mysqli->affected_rows > 0) {
      $response = [
        "message" => "Se eliminó correctamente el Cliente",
        "status" => 1
      ];
    }
    echo json_encode($response);
  }
}
