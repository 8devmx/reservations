<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

if ($post) {
  $users = new User();
  switch ($post['action']) {
    case 'showData':
      $users->getAllData($post['query'] ?? '');
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
    case 'filter':
      $users->filterData($post['role']);
      break;
  }
}

class User
{
  public function getAllData($query = '')
  {
    global $mysqli;
    $sql = "SELECT users.id, users.name as name, users.email, users.phone, users.active, roles.name as rol FROM users LEFT JOIN roles on users.rol_id = roles.id";
    if ($query !== '') {
      $sql .= " WHERE users.name LIKE ? OR users.email LIKE ? OR users.phone LIKE ?";
      $stmt = $mysqli->prepare($sql);
      $search = "%$query%";
      $stmt->bind_param("sss", $search, $search, $search);
    } else {
      $stmt = $mysqli->prepare($sql);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_object()) {
      $data[] = $row;
    }
    $stmt->close();
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
  public function filterData($role)
{
  global $mysqli;
  if ($role === 'all') {
    $query = "SELECT * FROM users";
    $stmt = $mysqli->prepare($query);
  } else {
    $query = "SELECT * FROM users WHERE rol_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $role);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  $data = [];
  while ($row = $result->fetch_object()) {
    $data[] = $row;
  }
  $stmt->close();
  echo json_encode($data);
}
}
?>