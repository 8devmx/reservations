<?php
require_once '_db.php';
class Events
{
  public function getAllData()
  {
    global $mysqli;
    $query = "SELECT*FROM events";
    return $mysqli->query($query);
  }
}
