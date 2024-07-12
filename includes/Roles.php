<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

if ($post) {
  $roles = new Roles();
  switch ($post['action']) {
    case 'showData':
      $roles->getAllData($post['query'] ?? '');
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
    case 'filter':
      $roles->filterData($post['status']);
      break;
  }
}

class Roles
{
  private $mysqli;

  public function __construct()
  {
    global $mysqli;
    $this->mysqli = $mysqli;
  }

  public function getAllData($query = '')
  {
    global $mysqli;
    $sql = "SELECT roles.id, roles.name, roles.active FROM roles";
    if ($query != '') {
        $sql .= " WHERE roles.name LIKE '%$query%'";
    }
    $data = [];
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_object()) {
        $data[] = $row;
    }
    echo json_encode($data);
  }

  public function getOneData($post)
  {
    $id = $post['id'];
    $query = "SELECT * FROM roles WHERE id = $id";
    $result = $this->mysqli->query($query);
    echo json_encode($result->fetch_object());
  }

  public function updateData($post)
  {
    $name = $post['name'];
    $status = $post['status'];
    $id = $post['id'];

    if (empty($name)) {
      $response = [
          "message" => "Todos los campos son obligatorios.",
          "status" => 1
      ];
      echo json_encode($response);
      return;
  }

    $query = "UPDATE IGNORE roles SET name = '$name', active = '$status' WHERE id = $id";
    $this->mysqli->query($query);

    $response = [
      "message" => "No se pudo editar el registro en la base de datos",
      "status" => 1
    ];
    if ($this->mysqli->affected_rows > 0) {
      $response = [
        "message" => "Se editó correctamente el Rol de $name",
        "status" => 2
      ];
    } else {
      $response = [
        "message" => "El Rol ya está registrado, no se ha insertado un nuevo registro",
        "status" => 1
      ];
    }
    echo json_encode($response);
  }

  public function insertData($data)
  {
    $nombre = $data['name'];
    $status = $data['status'];

    if (empty($nombre)) {
      $response = [
          "message" => "Todos los campos son obligatorios.",
          "status" => 1
      ];
      echo json_encode($response);
      return;
  }
  
    $query = "INSERT IGNORE INTO roles (name, active) VALUES ('$nombre', '$status')";
    $this->mysqli->query($query);

    $response = [
      "message" => "No se pudo almacenar el registro en la base de datos",
      "status" => 1
    ];
    if ($this->mysqli->insert_id != 0) {
      $response = [
        "message" => "Se registró correctamente el Rol de $nombre",
        "status" => 2
      ];
    } else {
      $response = [
        "message" => "El Rol ya está registrado, no se ha insertado un nuevo registro",
        "status" => 1
      ];
    }
    echo json_encode($response);
  }

  public function deleteData($id)
  {
    $query = "DELETE FROM roles WHERE id = $id";
    $this->mysqli->query($query);

    $response = [
      "message" => "No se pudo eliminar el registro",
      "status" => 0
    ];
    if ($this->mysqli->affected_rows > 0) {
      $response = [
        "message" => "Se eliminó correctamente el Rol",
        "status" => 1
      ];
    }
    echo json_encode($response);
  }

  public function filterData($status)
  {
    global $mysqli;
    $sql = "SELECT roles.id, roles.name, roles.active FROM roles";
    if ($status !== 'all') {
        $sql .= " WHERE roles.active = '$status'";
    }
    $data = [];
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_object()) {
        $data[] = $row;
    }
    echo json_encode($data);
}
}
?>