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
<h1>Administración de Ofertas de La Plaza del Juntos Compremos</h1>
<p>Presiona sobre la oferta para Administrar pedidos, </br>
Presiona sobre el estado de Activo para cambiarlo.</p>

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
      <th>Editar</th>
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
          echo "<td class='tablacentro' style='background-color:" . $colorVerde . "'><a class='confirmacion' href='actividad.php?P=1&C=0&O=" . $row["ID"] . "'>Si</a></td>";
        } else {
          echo "<td class='tablacentro' style='background-color:" . $colorRojo . "'><a class='confirmacion' href='actividad.php?P=1&C=1&O=" . $row["ID"] . "'>No</a></td>";
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
      $sql_pedido = "SELECT SUM(Cantidad) AS TotalPedidos FROM pedidos WHERE ID_OFERTA = $idoferta";
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
      <td><a href='pedidos_master.php?ID=" . $idoferta . "'>Ir >>></a></td>
      <td class='tablacentro'><a href='oferta_editar.php?ID=" . $idoferta . "'><img src='editar.png' alt=editar></a></td>
    </tr>";
  }
} else {
  echo "
      <tr>
        <td colspan='9'>Sin Ofertas</td>
      </tr>";
}

?>
<script>
var elems = document.getElementsByClassName('confirmacion');
var confirmIt = function (e) {
      if (!confirm('¿Estás segura que quieres cambiar el estado de esta oferta?')) e.preventDefault();
  };
  for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
    }
</script>
</tbody>
</table>

</br><button><a href='oferta_nueva.php'>Agregar nueva oferta</a></button>


</html>
