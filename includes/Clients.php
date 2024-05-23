<?php
require_once '_db.php';
class Clients
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT clients.id, clients.name as name, clients.email, clients.phone, clients.active  FROM clients ";
    return $mysqli->query($query);
  }
}