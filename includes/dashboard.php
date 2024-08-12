<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

<<<<<<< Updated upstream
=======
date_default_timezone_set('America/Mexico_City'); // Ajusta esto según tu zona horaria

>>>>>>> Stashed changes
if ($post) {
    $events = new Events();
    switch ($post['action']) {
        case 'showData':
            $events->getAllData($post['client_id'] ?? '');
            break;
<<<<<<< Updated upstream
=======
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
>>>>>>> Stashed changes
    }
}

class Events
{
<<<<<<< Updated upstream
    public function getAllData($client_id = '') {
        global $mysqli;
        $sql = "SELECT events.id, events.title, events.start_date, events.start_hout, events.end_date, events.end_hour, events.client_id, events.active, clients.name AS client_name 
                FROM events 
                LEFT JOIN clients ON events.client_id = clients.id";

        if (!empty($client_id)) {
            $sql .= " WHERE events.client_id = " . intval($client_id);
        }
        
        $result = $mysqli->query($sql);
=======
    public function getAllData($client_id = '')
    {
        global $mysqli;
        $today = date('Y-m-d'); // Obtén la fecha de hoy
        $query = "SELECT events.id, events.title as title, events.description, events.start_date, events.start_hout, events.end_date, events.end_hour, events.client_id, events.user_id, events.active, clients.name as client, users.name as user 
                  FROM events 
                  LEFT JOIN clients on events.client_id = clients.id 
                  LEFT JOIN users on events.user_id = users.id 
                  WHERE DATE(events.start_date) = '$today'"; // Filtra por la fecha de hoy

        // Agregar filtro de cliente si se ha seleccionado uno
        if (!empty($client_id)) {
            $query .= " AND events.client_id = '$client_id'";
        }

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
>>>>>>> Stashed changes
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
<<<<<<< Updated upstream

        echo json_encode($data);
    }

    public function getAllClients() {
        global $mysqli;
        $sql = "SELECT id, name FROM clients";
        $result = $mysqli->query($sql);
        $clients = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $clients[] = $row;
            }
=======
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
>>>>>>> Stashed changes
        }
        return $clients;
    }
}
<<<<<<< Updated upstream
?>
=======
>>>>>>> Stashed changes
