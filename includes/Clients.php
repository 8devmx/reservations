<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

if ($post) {
    $clients = new Clients();
    switch ($post['action']) {
        case 'showData':
            $clients->getAllData($post['query'] ?? '');
            break;
        case 'insert':
            $clients->insertData($post);
            break;
        case 'delete':
            $clients->deleteData($post["id"]);
            break;
        case 'selectOne':
            $clients->getOneData($post);
            break;
        case 'update':
            $clients->updateData($post);
            break;
        case 'filter':
            $clients->filterData($post['status']);
            break;
    }
}

class Clients
{
    public function getAllData($query = '')
    {
        global $mysqli;
        $sql = "SELECT clients.id, clients.name, clients.email, clients.phone, clients.active FROM clients";
        if ($query != '') {
            $sql .= " WHERE clients.name LIKE '%$query%'";
        }
        $data = [];
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
    public function getClientsForEvents()
    {
        global $mysqli;
        $sql = "SELECT clients.id, clients.name, clients.email, clients.phone, clients.active FROM clients WHERE active = 1";
        $data = [];
        $result = $mysqli->query($sql);
        return $result;
    }

    public function getOneData($post)
    {
        $id = $post['id'];
        global $mysqli;
        $query = "SELECT * FROM clients WHERE id = $id";
        $result = $mysqli->query($query);
        echo json_encode($result->fetch_object());
    }

    public function updateData($post)
    {
        $name = $post['name'];
        $email = $post['email'];
        $phone = $post['phone'];
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

        $query = "UPDATE  IGNORE clients SET name = '$name', email = '$email', phone = '$phone', active = '$status' WHERE id = $id";
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
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $status = $data['status'];

        if (empty($name) || empty($email) || empty($phone)) {
            $response = [
                "message" => "Todos los campos son obligatorios.",
                "status" => 1
            ];
            echo json_encode($response);
            return;
        }
      
        $query = "INSERT IGNORE INTO clients (name, email, phone, active) VALUES ('$name', '$email', '$phone', '$status')";
        $mysqli->query($query);

        $response = [
            "message" => "No se pudo almacenar el registro en la base de datos",
            "status" => 1
        ];
        if ($mysqli->insert_id != 0) {
            $response = [
                "message" => "Se registró correctamente el usuario de " . $name,
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

    public function filterData($status)
    {
        global $mysqli;
        $sql = "SELECT clients.id, clients.name, clients.email, clients.phone, clients.active FROM clients";
        if ($status !== 'all') {
            $sql .= " WHERE clients.active = '$status'";
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
