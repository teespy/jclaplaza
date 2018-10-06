<?php
include("conexion.php");

$variable = $_GET["P"];
$cambiar = $_GET["C"];
$idoferta = $_GET["O"];
$idpedido = $_GET["I"];

$variable = stripslashes($variable);
$variable = mysqli_real_escape_string($conn, $variable);
$cambiar = stripslashes($cambiar);
$cambiar = mysqli_real_escape_string($conn, $cambiar);
$idoferta = stripslashes($idoferta);
$idoferta = mysqli_real_escape_string($conn, $idoferta);
$idpedido = stripslashes($idpedido);
$idpedido = mysqli_real_escape_string($conn, $idpedido);

if ($variable == 1) {
$sql_cambiar_estado = "UPDATE pedidos SET PAGADO='$cambiar' WHERE ID='$idpedido'";
if ($conn->query($sql_cambiar_estado) === TRUE) {
  echo "<script language='javascript'>window.location='pedidos.php?ID=" . $idoferta . "'</script>";
  }
} elseif ($variable == 2) {
$sql_cambiar_estado = "UPDATE pedidos SET RETIRADO='$cambiar' WHERE ID='$idpedido'";
if ($conn->query($sql_cambiar_estado) === TRUE) {

  echo "<script language='javascript'>window.location='pedidos.php?ID=" . $idoferta . "'</script>";
  }
} elseif ($variable == 99) {
$sql_cambiar_estado = "UPDATE pedidos SET PAGO_VALIDADO='$cambiar' WHERE ID='$idpedido'";
if ($conn->query($sql_cambiar_estado) === TRUE) {

  echo "<script language='javascript'>window.location='pedidos_master.php?ID=" . $idoferta . "'</script>";
  }
} elseif ($variable == 66) {
$sql_cambiar_estado = "UPDATE pedidos SET ELIMINADO='$cambiar' WHERE ID='$idpedido'";
if ($conn->query($sql_cambiar_estado) === TRUE) {

  echo "<script language='javascript'>window.location='pedidos_master.php?ID=" . $idoferta . "'</script>";
  }
}

?>
