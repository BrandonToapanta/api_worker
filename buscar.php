<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Content-Type: application/json; charset=UTF-8");

include "config.php";
include "utils.php";

$dbConn =  connect($db);
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  header("Access-Control-Allow-Methods: GET, POST, PUT");
  header("Content-Type: application/json; charset=UTF-8");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $nombre = $_GET['emp_nombres'];
  $id = $_GET['id'];

  if (!empty($nombre) && !empty($id)) {
    $sql = $dbConn->prepare("SELECT id, emp_nombres, emp_apellidos, emp_status FROM empleado WHERE id LIKE :id OR emp_nombres LIKE :emp_nombres");
    $sql->bindValue(':id', '%' . $_GET['id'] . '%');
    $sql->bindValue(':emp_nombres', '%' . $_GET['emp_nombres'] . '%');
  } elseif (!empty($id)&& empty($nombre)) {
    $sql = $dbConn->prepare("SELECT id, emp_nombres, emp_apellidos, emp_status FROM empleado WHERE id LIKE :id");
    $sql->bindValue(':id', '%' . $_GET['id'] . '%');
  } elseif (empty($id) && !empty($nombre)) {
    $sql = $dbConn->prepare("SELECT id, emp_nombres, emp_apellidos, emp_status FROM empleado WHERE emp_nombres LIKE :emp_nombres");
    $sql->bindValue(':emp_nombres', '%' . $_GET['emp_nombres'] . '%');
  }
   else {
    $sql = $dbConn->prepare("SELECT id, emp_nombres, emp_apellidos, emp_status FROM empleado");
  }

  $sql->execute(); // Ejecuta la consulta preparada
  $sql->setFetchMode(PDO::FETCH_ASSOC); // Establece el modo de recuperación de datos
  $resultado = $sql->fetchAll(); // Recupera los datos de la consulta

  header("HTTP/1.1 200 OK");
  echo json_encode($resultado); // Envía los datos como JSON
  exit();
}
