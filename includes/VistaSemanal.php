<?php
$post = json_decode(file_get_contents('php://input'), true);
require_once '_db.php';

if ($post) {
    $events = new Events();
    switch ($post['action']) {
        case 'showData':
            $events->getAllData($post['client_id'] ?? '');
            break;
    }
}

class Events
{
    public function getAllData($client_id = '') {
        global $mysqli;
        $sql = "SELECT events.id, events.title, events.start_date, events.start_hout, events.end_date, events.end_hour, events.client_id, events.active, clients.name AS client_name 
                FROM events 
                LEFT JOIN clients ON events.client_id = clients.id";

        if (!empty($client_id)) {
            $sql .= " WHERE events.client_id = " . intval($client_id);
        }
        
        $result = $mysqli->query($sql);
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }

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
        }
        return $clients;
    }
}
?>
