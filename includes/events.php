<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';
if ($post) {
  switch ($post['action']) {
    case 'insert':
      $events = new Events();
      $events->insertData($post);
      break;
    case 'delete':
      $events = new Events();
      $events->deleteData($post);
      break;
  }
}
class Events
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT*FROM events";
    return $mysqli->query($query);
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
    $query =  "INSERT INTO events (title, description, start_date, start_hout, end_date, end_hour, client_id, user_id, map, active) VALUES ('$Titulo', '$Descripcion', '$Fecha_de_Inicio', '$Hora_de_Inicio','$Fecha_de_Fin','$Hora_de_Fin','$Cliente','$user_id','$Mapa','$status')";
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
    }
    echo json_encode($response);
  }

  public function deleteData($data)
  {
    $id = $data['id'];
    global $mysqli;
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
}
