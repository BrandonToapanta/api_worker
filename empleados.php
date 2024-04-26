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
  if (isset($_GET['id'])) {
    $sql = $dbConn->prepare("SELECT * FROM empleado where id=:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $row_count = $sql->fetchColumn();
    if ($row_count == 0) {
      header("HTTP/1.1 204 No Content");
      echo "No existe el empleado ", $_GET['id'];
    } else {
      $sql = $dbConn->prepare("SELECT * FROM empleado where id=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
      exit();
    }
  } else {
    $sql = $dbConn->prepare("SELECT id, emp_nombres, emp_apellidos, emp_status FROM empleado LIMIT 20");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $data = json_decode(file_get_contents("php://input"));

  $emp_nombres = $data->emp_nombres;
  $emp_apellidos = $data->emp_apellidos;
  $emp_cedula = $data->emp_cedula;
  $emp_fec_nacimiento = $data->emp_fec_nacimiento;
  $emp_correo = $data->emp_correo;
  $emp_obs_pers = $data->emp_obs_pers;
  $emp_foto = $data->emp_foto;
  $emp_fec_ingreso = $data->emp_fec_ingreso;
  $emp_cargo = $data->emp_cargo;
  $emp_departamento = $data->emp_departamento;
  $emp_salario = $data->emp_salario;
  $emp_jor_parcial = $data->emp_jor_parcial;
  $emp_obs_lab = $data->emp_obs_lab;
  $emp_status = 'vigente';
  $provPersona_id = $data->provPersona_id;
  $provLaboral_id = $data->provLaboral_id;

  $statement = $dbConn->prepare("SELECT * FROM empleado where emp_cedula=:emp_cedula");
  $statement->bindParam(':emp_cedula', $emp_cedula);
  $statement->execute();
  $row_count = $statement->fetchColumn();
  if ($row_count > 0) {
    echo "Ya existe el empleado";
  } else {
    $sql = "INSERT INTO empleado (emp_nombres, emp_apellidos, emp_cedula, emp_fec_nacimiento, emp_correo, emp_obs_pers, emp_foto, emp_fec_ingreso, emp_cargo, emp_departamento, emp_salario, emp_jor_parcial, emp_obs_lab, emp_status, provPersona_id, provLaboral_id)  
            VALUES
            (:emp_nombres, :emp_apellidos, :emp_cedula, :emp_fec_nacimiento, :emp_correo, :emp_obs_pers, :emp_foto, :emp_fec_ingreso, :emp_cargo, :emp_departamento, :emp_salario, :emp_jor_parcial, :emp_obs_lab, :emp_status, :provPersona_id, :provLaboral_id)";

    $statement = $dbConn->prepare($sql);

    $statement->bindParam(':emp_nombres', $emp_nombres);
    $statement->bindParam(':emp_apellidos', $emp_apellidos);
    $statement->bindParam(':emp_cedula', $emp_cedula);
    $statement->bindParam(':emp_fec_nacimiento', $emp_fec_nacimiento);
    $statement->bindParam(':emp_correo', $emp_correo);
    $statement->bindParam(':emp_obs_pers', $emp_obs_pers);
    $statement->bindParam(':emp_foto', $emp_foto);
    $statement->bindParam(':emp_fec_ingreso', $emp_fec_ingreso);
    $statement->bindParam(':emp_cargo', $emp_cargo);
    $statement->bindParam(':emp_departamento', $emp_departamento);
    $statement->bindParam(':emp_salario', $emp_salario);
    $statement->bindParam(':emp_jor_parcial', $emp_jor_parcial);
    $statement->bindParam(':emp_obs_lab', $emp_obs_lab);
    $statement->bindParam(':emp_status', $emp_status);
    $statement->bindParam(':provPersona_id', $provPersona_id);
    $statement->bindParam(':provLaboral_id', $provLaboral_id);

    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if ($postId) {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

  $data = json_decode(file_get_contents("php://input"));

  $emp_nombres = $data->emp_nombres;
  $emp_apellidos = $data->emp_apellidos;
  $emp_cedula = $data->emp_cedula;
  $emp_fec_nacimiento = $data->emp_fec_nacimiento;
  $emp_correo = $data->emp_correo;
  $emp_obs_pers = $data->emp_obs_pers;
  $emp_foto = $data->emp_foto;
  $emp_fec_ingreso = $data->emp_fec_ingreso;
  $emp_cargo = $data->emp_cargo;
  $emp_departamento = $data->emp_departamento;
  $emp_salario = $data->emp_salario;
  $emp_jor_parcial = $data->emp_jor_parcial;
  $emp_obs_lab = $data->emp_obs_lab;
  $emp_status = 'vigente';
  $provPersona_id = $data->provPersona_id;
  $provLaboral_id = $data->provLaboral_id;

  $statement = $dbConn->prepare("SELECT * FROM empleado where emp_cedula=:emp_cedula");
  $statement->bindParam(':emp_cedula', $emp_cedula);
  $statement->execute();
  $row_count = $statement->fetchColumn();

  if ($row_count > 0) {
    $sql = "UPDATE empleado SET emp_nombres=:emp_nombres, emp_apellidos=:emp_apellidos, emp_fec_nacimiento=:emp_fec_nacimiento, emp_correo=:emp_correo, emp_obs_pers=:emp_obs_pers, emp_foto=:emp_foto, emp_fec_ingreso=:emp_fec_ingreso, emp_cargo=:emp_cargo, emp_departamento=:emp_departamento, emp_salario=:emp_salario, emp_jor_parcial=:emp_jor_parcial, emp_obs_lab=:emp_obs_lab, emp_status=:emp_status, provPersona_id=:provPersona_id, provLaboral_id=:provLaboral_id where emp_cedula=:emp_cedula";

    $statement = $dbConn->prepare($sql);

    $statement->bindParam(':emp_nombres', $emp_nombres);
    $statement->bindParam(':emp_apellidos', $emp_apellidos);
    $statement->bindParam(':emp_cedula', $emp_cedula);
    $statement->bindParam(':emp_fec_nacimiento', $emp_fec_nacimiento);
    $statement->bindParam(':emp_correo', $emp_correo);
    $statement->bindParam(':emp_obs_pers', $emp_obs_pers);
    $statement->bindParam(':emp_foto', $emp_foto);
    $statement->bindParam(':emp_fec_ingreso', $emp_fec_ingreso);
    $statement->bindParam(':emp_cargo', $emp_cargo);
    $statement->bindParam(':emp_departamento', $emp_departamento);
    $statement->bindParam(':emp_salario', $emp_salario);
    $statement->bindParam(':emp_jor_parcial', $emp_jor_parcial);
    $statement->bindParam(':emp_obs_lab', $emp_obs_lab);
    $statement->bindParam(':emp_status', $emp_status);
    $statement->bindParam(':provPersona_id', $provPersona_id);
    $statement->bindParam(':provLaboral_id', $provLaboral_id);
    $statement->execute();
  } else {
    echo "No existe el empleado";
  }
}
