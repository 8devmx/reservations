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
    case 'search':
      $roles->searchData($post['query']);
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

  public function getAllData()
  {
    $query = "SELECT * FROM roles";
    $result = $this->mysqli->query($query);
    $data = [];
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

    $query = "UPDATE roles SET name = '$name', active = '$status' WHERE id = $id";
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
    }
    echo json_encode($response);
  }

  public function insertData($data)
  {
    $nombre = $data['name'];
    $status = $data['status'];

    $query = "INSERT INTO roles (name, active) VALUES ('$nombre', '$status')";
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

  public function searchData($query)
  {
    $search = "%$query%";
    $query = "SELECT * FROM roles WHERE name LIKE '$search'";
    $result = $this->mysqli->query($query);
    $data = [];
    while ($row = $result->fetch_object()) {
      $data[] = $row;
    }
    echo json_encode($data);
  }

  public function filterData($status)
  {
    $query = ($status == 'all') ? "SELECT * FROM roles" : "SELECT * FROM roles WHERE active = '$status'";
    $result = $this->mysqli->query($query);
    $data = [];
    while ($row = $result->fetch_object()) {
      $data[] = $row;
    }
    echo json_encode($data);
  }
}
?>

