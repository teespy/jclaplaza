<?php
include("conexion.php");
mysqli_set_charset($conn,"utf8");

$datos = array("idoferta", "nombre", "cantidad", "variedad");
foreach ($datos as $dato) {
  ${$dato} = $_POST[$dato];

  ${$dato} = stripslashes(${$dato});
  ${$dato} = mysqli_real_escape_string($conn, ${$dato});
}

/*
$idoferta = $_POST["idoferta"];
$nombre = $_POST["nombre"];
$cantidad = $_POST["cantidad"];
$variedad = $_POST["variedad"];

$cantidad = stripslashes($cantidad);
$cantidad = mysqli_real_escape_string($conn, $cantidad);
$idoferta = stripslashes($idoferta);
$idoferta = mysqli_real_escape_string($conn, $idoferta);
$nombre = stripslashes($nombre);
$nombre = mysqli_real_escape_string($conn, $nombre);
$variedad = stripslashes($variedad);
$variedad = mysqli_real_escape_string($conn, $variedad);
*/


$sql_hacer_pedido = "INSERT INTO pedidos (ID_OFERTA, IDENTIFICACION, CANTIDAD, VARIEDAD, PAGADO, RETIRADO, PAGO_VALIDADO, ELIMINADO) VALUES ('$idoferta', '$nombre', '$cantidad', '$variedad', 0, 0, 0, 0)";

if ($conn->query($sql_hacer_pedido) === TRUE) {

  echo "<script language='javascript'>window.location='pedidos.php?ID=" . $idoferta . "'</script>";

}


?>
