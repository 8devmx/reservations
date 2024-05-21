<?php
require_once '_db.php';
class User
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT users.id, users.name as name, users.email, users.phone, users.active, roles.name as rol FROM users  LEFT JOIN roles  on users.rol_id = roles.id";
    return $mysqli->query($query);
  }
}
