<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';
if ($post) {
  switch ($post['action']) {
    case 'insert':
      $clients = new Clients();
      $clients->insertData($post);
      break;
    case 'delete':
      $clients = new Clients();
      $clients->deleteData($post['id']);
      break;
  }
}

class Clients
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT clients.id, clients.name, clients.email, clients.phone, clients.active FROM clients";
    return $mysqli->query($query);
  }

  public function insertData($data)
  {
    global $mysqli;
    $name = $mysqli->real_escape_string($data['name']);
    $email = $mysqli->real_escape_string($data['email']);
    $phone = $mysqli->real_escape_string($data['phone']);
    $active = (int) $data['status'];
    $query = "INSERT INTO clients (name, email, phone, active) VALUES ('$name', '$email', '$phone', '$active')";
    $mysqli->query($query);
    $response = [
      "message" => "No se pudo almacenar el registro en la base de datos",
      "status" => 0
    ];
    if ($mysqli->insert_id != 0) {
      $response = [
        "message" => "Se registró correctamente el Cliente de " . $name,
        "status" => 1
      ];
    }
    echo json_encode($response);
  }

  public function deleteData($id)
  {
    global $mysqli;
    $id = (int) $id;
    $query = "DELETE FROM clients WHERE id = $id";
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
