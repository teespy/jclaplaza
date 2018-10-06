<?php
include("conexion.php");

$variable = $_GET["P"];
$cambiar = $_GET["C"];
$idoferta = $_GET["O"];

$variable = stripslashes($variable);
$variable = mysqli_real_escape_string($conn, $variable);
$cambiar = stripslashes($cambiar);
$cambiar = mysqli_real_escape_string($conn, $cambiar);
$idoferta = stripslashes($idoferta);
$idoferta = mysqli_real_escape_string($conn, $idoferta);

if ($variable == 1) {
$sql_cambiar_actividad = "UPDATE ofertas SET ACTIVA='$cambiar' WHERE ID='$idoferta'";
if ($conn->query($sql_cambiar_actividad) === TRUE) {
  echo "<script language='javascript'>window.location='ofertas_master.php'</script>";
  }
}

?>
