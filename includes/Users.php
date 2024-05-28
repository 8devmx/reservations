<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

class User
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT users.id, users.name as name, users.email, users.phone, users.active, roles.name as rol FROM users LEFT JOIN roles on users.rol_id = roles.id";
    return $mysqli->query($query);
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
}

if ($post && $post['action'] == 'insert') {
  $user = new User();
  $user->insertData($post);
}
?>
