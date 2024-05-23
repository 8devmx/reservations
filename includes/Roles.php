<?php
require_once '_db.php';
class Roles
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT * FROM roles";
    return $mysqli->query($query);
  }
}
