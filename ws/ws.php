<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db);

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id']))
    {
      $sql = $dbConn->prepare("SELECT P.ID_PERSONA, P.IDENTIFICACION, P.NOMBRE, P.FECHA_NACIMIENTO, P.ESTADO AS ESTADO_PERSONA, R.ESTADO AS ESTADO_HOGAR,  R.ID_REL_HOG_PER, R.ID_HOGAR FROM Persona P LEFT JOIN Rel_Hogar_Persona R on P.ID_PERSONA = R.ID_PERSONA WHERE P.IDENTIFICACION=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
    }
    else {
      $sql = $dbConn->prepare("SELECT * FROM Persona");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
  }
}

header("HTTP/1.1 400 Bad Request");
?>