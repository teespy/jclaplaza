<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
<?php include 'estilo.css'; ?>
</style>
</head>
<body>
<h1>Ofertas de La Plaza del Juntos Compremos</h1>
<p>Presiona sobre la oferta para saber los detalles y/o hacer tu pedido</p>

<table>
  <thead>
    <tr>
      <th>Nº</th>
      <th>Activa</th>
      <th>Nombre</th>
      <th>Fecha de Inicio</th>
      <th>Fecha de Cierre</th>
      <th>Pedido Mínimo</th>
      <th>Pedido Máximo</th>
      <th>Llevamos</th>
      <th>Detalles</th>
    </tr>
  <thead>
  <tbody>

<?php
// archivo de conexion a la bd
include("conexion.php");

mysqli_set_charset($conn,"utf8");

//algunas definiciones de variables, colores principalmente
$colorRojo = "#f44949";
$colorVerde = "#5fa761";




$sql = "SELECT * FROM ofertas";

$sql1 = mysqli_query($conn, $sql);
if (mysqli_num_rows($sql1) > 0) {
  while ($row = mysqli_fetch_assoc($sql1)) {
    echo "
    <tr>
      <td>" . $row["ID"] . "</td>";
        if ($row["ACTIVA"] == 1) {
          echo "<td class='tablacentro' style='background-color:" . $colorVerde . "'> Si </td>";
        } else {
          echo "<td class='tablacentro' style='background-color:" . $colorRojo . "'> No </td>";
        }
    echo "
      <td>" . $row["NOMBRE"] . "</td>
      <td class='tablacentro'>" . date('d-M-Y', strtotime($row["FECHA_I"])) . "</td>";
    if ($row["FECHA_C"] > "2018-01-01") {
        echo "<td class='tablacentro'>" . date('d-M-Y', strtotime($row["FECHA_C"])) . "</td>";
      } else {
        echo "<td class='tablacentro'>---</td>";
      }
    echo "
      <td class='tablacentro'>" . $row["PED_MIN"] . "</td>
      <td class='tablacentro'>" . $row["PED_MAX"] . "</td>";
      $idoferta = $row["ID"];
      $sql_pedido = "SELECT SUM(Cantidad) AS TotalPedidos FROM pedidos WHERE ID_OFERTA = $idoferta AND ELIMINADO != 1";
      $sql_pedido1 = mysqli_query($conn, $sql_pedido);
      $cantidad = mysqli_fetch_array($sql_pedido1);
      if ($cantidad["TotalPedidos"] > 0) {
        if (($cantidad["TotalPedidos"] >= $row["PED_MAX"]) && ($row["PED_MAX"] != 0)) {
          echo "<td class='tablacentro' style='background-color:" . $colorRojo . ";'>";
        } else {
          echo "<td class='tablacentro'>";
        }
        echo $cantidad["TotalPedidos"] . "</td>";
      } else {
        echo "<td class='tablacentro'>0</td>";
      }

    echo "
      <td><a href='pedidos.php?ID=" . $idoferta . "'>Ir >>></a></td>
    </tr>";
  }
} else {
  echo "
      <tr>
        <td colspan='9'>Sin Ofertas</td>
      </tr>";
}
?>

</tbody>
</table>

</html>
