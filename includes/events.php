<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

if ($post) {
  $events = new Events();
  switch ($post['action']) {
    case 'showData':
      $events->getAllData();
      break;
    case 'insert':
      $events = new Events();
      $events->insertData($post);
      break;
    case 'delete':
      $events = new Events();
      $events->deleteData($post);
      break;
    case 'selectOne':
      $events = new Events();
      $events->getOneData($post);
      break;
    case 'update':
      $events = new Events();
      $events->updateData($post);
      break;
    case 'search':
      $events->searchData($post['query']);
      break;
    case 'filtroData':
      $events->filtroData($post['client_id']);
      break;
  }
}
class Events
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT 
            events.id, 
            events.title as title, 
            events.description, 
            events.start_date, 
            events.start_hout, 
            events.end_date, 
            events.end_hour, 
            events.map, 
            events.client_id, 
            events.user_id, 
            events.active, 
            clients.name as client,
            users.name as user
        FROM events 
        LEFT JOIN clients on events.client_id = clients.id
        LEFT JOIN users on events.user_id = users.id";
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
    $query = "SELECT * FROM events where id = $id";
    $result = $mysqli->query($query);
    echo json_encode($result->fetch_object());
  }

  public function updateData($post)
  {
    $title = $post['title'];
    $description = $post['description'];
    $start_date = $post['start_date'];
    $start_hout = $post['start_hout'];
    $end_date = $post['end_date'];
    $end_hour = $post['end_hour'];
    $client = $post['client'];
    $user = $post['user'];
    $map = $post['map'];
    $status = $post['status'];
    $id = $post['id'];

<<<<<<< Updated upstream
    $query = "UPDATE events SET title = '$title', description = '$description', start_date = '$start_date', start_hout = '$start_hout', end_date = '$end_date', end_hour = '$end_hour',  client_id = '$client', user_id = '$user', map = '$map', active = '$status' WHERE id = $id";
=======
    if (empty($title) || empty($description) || empty($start_date) || empty($start_hout) || empty($end_date) || empty($end_hour) || empty($map)) {
      $response = [
          "message" => "Todos los campos son obligatorios.",
          "status" => 1
      ];
      echo json_encode($response);
      return;
  }

    $query = "UPDATE IGNORE events SET title = '$title', description = '$description', start_date = '$start_date', start_hout = '$start_hout', end_date = '$end_date', end_hour = '$end_hour',  client_id = '$client', user_id = '$user', map = '$map', active = '$status' WHERE id = $id";
>>>>>>> Stashed changes

    global $mysqli;
    $mysqli->query($query);

    $response = [
      "message" => "No se pudo editar el registro en la base de datos",
      "status" => 1
    ];
    if ($mysqli->affected_rows > 0) {
      $response = [
        "message" => "Se editó correctamente el usuario de " . $title,
        "status" => 2
      ];
    } else {
      $response = [
        "message" => "El Titulo ya está registrado, no se ha insertado un nuevo registro",
        "status" => 1
      ];
    }
    echo json_encode($response);
  }

  public function insertData($data)
  {
    global $mysqli;
    // Verificar si el user_id existe en la tabla de usuarios
    $user_id = $data['user_id'];
    $user_check_query = "SELECT id FROM users WHERE id='$user_id' LIMIT 1";
    $result = $mysqli->query($user_check_query);
    if ($result->num_rows == 0) {
      // El user_id no existe en la tabla de usuarios
      $response = [
        "message" => "El ID de usuario proporcionado no es válido",
        "status" => 0
      ];
      echo json_encode($response);
      return;
    }

    $Titulo = $data['title'];
    $Descripcion = $data['description'];
    $Fecha_de_Inicio = $data['start_date'];
    $Hora_de_Inicio = $data['start_hout'];
    $Fecha_de_Fin = $data['end_date'];
    $Hora_de_Fin = $data['end_hour'];
    $Cliente = $data['client_id'];
    $Mapa = $data['map'];
    $status = $data['status'];
    $query =  "INSERT IGNORE INTO events (title, description, start_date, start_hout, end_date, end_hour, client_id, user_id, map, active) VALUES ('$Titulo', '$Descripcion', '$Fecha_de_Inicio', '$Hora_de_Inicio','$Fecha_de_Fin','$Hora_de_Fin','$Cliente','$user_id','$Mapa','$status')";
    $mysqli->query($query);
    $response = [
      "message" => "No se pudo almacenar el registro en la base de datos",
      "status" => 0
    ];
    if ($mysqli->insert_id != 0) {
      $response = [
        "message" => "Se registró correctamente el Evento de " . $Titulo,
        "status" => 1
      ];
    } else {
      $response = [
        "message" => "El Titulo ya está registrado, no se ha insertado un nuevo registro",
        "status" => 1
      ];
    }
    echo json_encode($response);
  }

  public function deleteData($data)
  {
    global $mysqli;
    $id = $data['id'];
    $query = "DELETE FROM events where id =  $id";
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

public function searchData($query)
  {
    global $mysqli;
    $searchQuery = "%" . $mysqli->real_escape_string($query) . "%";
    $query = "SELECT 
            events.id, 
            events.title as title, 
            events.description, 
            events.start_date, 
            events.start_hout, 
            events.end_date, 
            events.end_hour, 
            events.map, 
            events.client_id, 
            events.user_id, 
            events.active, 
            clients.name as client,
            users.name as user
        FROM events 
        LEFT JOIN clients on events.client_id = clients.id
        LEFT JOIN users on events.user_id = users.id WHERE title LIKE ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_object()) {
      $data[] = $row;
    }
    $stmt->close();
    echo json_encode($data);
  }

  public function filtroData($client_id)
{
  global $mysqli;
  $query = "SELECT 
          events.id, 
          events.title as title, 
          events.description, 
          events.start_date, 
          events.start_hout, 
          events.end_date, 
          events.end_hour, 
          events.map, 
          events.client_id, 
          events.user_id, 
          events.active, 
          clients.name as client,
          users.name as user
      FROM events 
      LEFT JOIN clients on events.client_id = clients.id
      LEFT JOIN users on events.user_id = users.id
      WHERE events.client_id = ?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param("i", $client_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = [];
  while ($row = $result->fetch_object()) {
    $data[] = $row;
  }
  $stmt->close();
  echo json_encode($data);
}

  public function getClients()
{
  global $mysqli;
  $query = "SELECT id, name FROM clients";
  $result = $mysqli->query($query);
  $clients = [];
  while ($row = $result->fetch_object()) {
    $clients[] = $row;
  }
  return $clients;
}

}
?>