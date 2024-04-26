<?php

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET");


include "config.php";
include "utils.php";


$dbConn =  connect($db);

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $sql = $dbConn->prepare("SELECT id, nombre_provincia FROM provincia");

  $sql->execute();
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  header("HTTP/1.1 200 OK");
  echo json_encode($sql->fetchAll());
  exit();
}

header("HTTP/1.1 400 Bad Request");
