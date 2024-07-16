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
    case 'login':
      $users->loginData($post);
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

  public function getUserForEvents()
  {
    global $mysqli;
    $sql = "SELECT users.id, users.name, users.email, users.password, users.phone, users.rol_id, users.active FROM users WHERE active = 1";
    $data = [];
    $result = $mysqli->query($sql);
    return $result;
  }

  public function getOneData($post)
  {
    $id = $post['id'];
    global $mysqli;
    $query = "SELECT * FROM users WHERE id = $id";
    $result = $mysqli->query($query);
    echo json_encode($result->fetch_object());
  }

  public function loginData($post)
  {
    global $mysqli;
    $email = $post['correo'];
    $password = $post['passwords'];
    $consulta = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND active = 1";
    $result = $mysqli->query($consulta);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo json_encode($row);
  }

  public function updateData($post)
  {
    $name = $post['name'];
    $email = $post['email'];
    $phone = $post['phone'];
    $rol = $post['rol'];
    $status = $post['status'];
    $id = $post['id'];

    if (empty($name) || empty($email) || empty($phone)) {
      $response = [
          "message" => "Todos los campos son obligatorios.",
          "status" => 1
      ];
      echo json_encode($response);
      return;
  }
    
    $query = "UPDATE IGNORE users SET name = '$name', email = '$email', phone = '$phone', rol_id = '$rol', active = '$status' WHERE id = $id";

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
    } else {
      $response = [
        "message" => "El correo electrónico o teléfono ya está registrado, no se ha insertado un nuevo registro",
        "status" => 1
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

    if (empty($nombre) || empty($email) || empty($phone)) {
      $response = [
          "message" => "Todos los campos son obligatorios.",
          "status" => 1
      ];
      echo json_encode($response);
      return;
  }

    $query = "INSERT IGNORE INTO users (name, email, phone, rol_id, active) VALUES ('$nombre', '$email', '$phone', '$rol', '$status')";
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
    } else {
      $response = [
        "message" => "El correo electrónico o teléfono ya está registrado, no se ha insertado un nuevo registro",
        "status" => 1
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
?>
