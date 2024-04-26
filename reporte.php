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
  $input = $_GET;
  $fields = getParams($input);

  if (!empty($fields) && $input[$fields] == 1) {
    $sql = $dbConn->prepare("SELECT empleado.emp_nombres, empleado.emp_apellidos, empleado.emp_cedula, empleado.id, empleado.emp_departamento, empleado.emp_cargo, empleado.emp_fec_ingreso,empleado.emp_status, empleado.emp_salario, empleado.emp_correo, provincia.nombre_provincia FROM empleado JOIN provincia ON empleado.provLaboral_id = provincia.id ORDER BY ".$fields." ASC");
  } elseif (!empty($fields) && $input[$fields] == 2) {
    $sql = $dbConn->prepare("SELECT empleado.emp_nombres, empleado.emp_apellidos, empleado.emp_cedula, empleado.id, empleado.emp_departamento, empleado.emp_cargo, empleado.emp_fec_ingreso,empleado.emp_status, empleado.emp_salario, empleado.emp_correo, provincia.nombre_provincia FROM empleado JOIN provincia ON empleado.provLaboral_id = provincia.id ORDER BY " . $fields . " DESC");
  }else {
    $sql = $dbConn->prepare("SELECT empleado.emp_nombres, empleado.emp_apellidos, empleado.emp_cedula, empleado.id, empleado.emp_departamento, empleado.emp_cargo, empleado.emp_fec_ingreso,empleado.emp_status, empleado.emp_salario, empleado.emp_correo, provincia.nombre_provincia FROM empleado JOIN provincia ON empleado.provLaboral_id = provincia.id");
  }

  $sql->execute();
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  header("HTTP/1.1 200 OK");
  echo json_encode($sql->fetchAll());
  exit();
}
