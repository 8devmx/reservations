<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../../css/styles.css">
<head>
  <?php
  include_once '../../includes/head.php';
  require_once '../../includes/events.php';
  $events = new Events();
  $clients = $events->getClients();
  ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include_once '../../includes/header.php'; ?>
  <div class="container-fluid">
    <div class="row">
      <?php include_once '../../includes/sidebar.php'; ?>

</body>
</html>