<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

if ($post) {
  $events = new Events();
  switch ($post['action']) {
    case 'showData':
      $events->getAllData($post['query'] ?? '');
      break;
    case 'insert':
      $events->insertData($post);
      break;
    case 'delete':
      $events->deleteData($post);
      break;
    case 'selectOne':
      $events->getOneData($post);
      break;
    case 'update':
      $events->updateData($post);
      break;
    case 'filtroData':
      $events->filtroData($post['client_id']);
      break;
  }
}

class Events
{
  public function getAllData($query = '')
  {
    global $mysqli;
    $searchQuery = '';
    if (!empty($query)) {
      $searchQuery = "WHERE events.title LIKE '%$query%'";
    }
    $query = "SELECT events.id, events.title as title, events.description, events.start_date, events.start_hout, events.end_date, events.end_hour, events.client_id, events.user_id, events.active, clients.name as client, users.name as user FROM events LEFT JOIN clients on events.client_id = clients.id LEFT JOIN users on events.user_id = users.id $searchQuery";
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
    $query = "SELECT * FROM events WHERE id = $id";
    $result = $mysqli->query($query);
    echo json_encode($result->fetch_object());
  }

  public function updateData($post)
  {
    global $mysqli;
    $id = $post['id'];
    $title = $post['title'];
    $description = $post['description'];
    $start_date = $post['start_date'];
    $start_hout = $post['start_hout'];
    $end_date = $post['end_date'];
    $end_hour = $post['end_hour'];
    $client_id = $post['client_id'];
    $user_id = $post['user_id'];
    $status = $post['status'];

    if (empty($title) || empty($description) || empty($start_date) || empty($start_hout) || empty($end_date) || empty($end_hour)) {
      $response = [
        "message" => "Todos los campos son obligatorios.",
        "status" => 1
      ];
      echo json_encode($response);
      return;
    }

    $query = "UPDATE events SET title = '$title', description = '$description', start_date = '$start_date', start_hout = '$start_hout', end_date = '$end_date', end_hour = '$end_hour', client_id = '$client_id', user_id = '$user_id', active = '$status' WHERE id = $id";

    $mysqli->query($query);

    $response = [
      "message" => "No se pudo editar el registro en la base de datos",
      "status" => 1
    ];
    if ($mysqli->affected_rows > 0) {
      $response = [
        "message" => "Se editó correctamente el Evento de " . $title,
        "status" => 2
      ];
    }
    echo json_encode($response);
  }

  public function insertData($data)
  {
    global $mysqli;
    $title = $data['title'];
    $description = $data['description'];
    $start_date = $data['start_date'];
    $start_hout = "00:00:00"; // Cambiar si se requiere un valor diferente
    $end_date = $data['end_date'];
    $end_hour = "00:00:00"; // Cambiar si se requiere un valor diferente
    $client_id = $data['client_id'];
    $user_id = $data['user_id'];
    $status = $data['status'];

    if (empty($title) || empty($description) || empty($start_date) || empty($end_date)) {
      $response = [
        "message" => "Todos los campos son obligatorios.",
        "status" => 1
      ];
      echo json_encode($response);
      return;
    }

    $query = "INSERT INTO events (title, description, start_date, start_hout, end_date, end_hour, client_id, user_id, active) VALUES ('$title', '$description', '$start_date', '$start_hout', '$end_date', '$end_hour', '$client_id', '$user_id', '$status')";
    $mysqli->query($query);

    $response = [
      "message" => "No se pudo almacenar el registro en la base de datos",
      "status" => 1
    ];
    if ($mysqli->insert_id != 0) {
      $response = [
        "message" => "Se registró correctamente el Evento de " . $title,
        "status" => 2
      ];
    }
    echo json_encode($response);
  }

  public function deleteData($data)
  {
    global $mysqli;
    $id = $data['id'];
    $query = "DELETE FROM events WHERE id =  $id";
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
      WHERE events.client_id = '$client_id'";
    $result = $mysqli->query($query);
    $data = [];
    while ($row = $result->fetch_object()) {
      $data[] = $row;
    }
    echo json_encode($data);
  }

  public function getClients()
  {
    global $mysqli;
    $query = "SELECT id, name FROM clients WHERE active = 1";
    $result = $mysqli->query($query);
    $clients = [];
    while ($row = $result->fetch_object()) {
      $clients[] = $row;
    }
    return $clients;
  }
}
