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
<?php
// archivo de conexion a la bd
include("conexion.php");

//recolectar datos GET
if (isset($_GET['ID'])) {
	$idOferta = $_GET['ID'];

  // Proteger
  $idOferta = stripslashes($idOferta);
  $$idOferta = mysqli_real_escape_string($conn, $idOferta);

// obtener los detalles de la oferta
mysqli_set_charset($conn,"utf8");
$sql_oferta = "SELECT * FROM ofertas WHERE ID = $idOferta";
$sql_oferta1 = mysqli_query($conn, $sql_oferta);
$detOferta = mysqli_fetch_array($sql_oferta1);

echo "
<a href='ofertas_master.php'>< Volver</a></br>
<h1>Detalles de los Pedidos:</h1>
<h3>Producto: " . $detOferta["NOMBRE"] . "</h3>";

echo "<h1>Listado de Pedidos Realizados</h1>
<table>
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Cantidad</th>
      <th>Variedad</th>
      <th>Pagado</th>
      <th>Retirado</th>
      <th>Pago_validado</th>
      <th>¿Eliminar?</th>
    </tr>
  </thead>
  <tbody>";

$sql_listado = "SELECT * FROM pedidos WHERE ID_OFERTA = $idOferta AND ELIMINADO != 1";
$sql_listado1 = mysqli_query($conn, $sql_listado);
if (mysqli_num_rows($sql_listado1) > 0) {
  while ($row = mysqli_fetch_assoc($sql_listado1)) {
    echo "
    <tr>
      <td>" . $row["IDENTIFICACION"] . "</td>
      <td>" . $row["CANTIDAD"] . "</td>
      <td>" . $row["VARIEDAD"] . "</td>";
    if ($row["PAGADO"] == 1) {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=1&C=0&O=" . $idOferta . "&I=" . $row["ID"] . "'>Si</a></td>";
    } else {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=1&C=1&O=" . $idOferta . "&I=" . $row["ID"] . "'>No</a></td>";
    }
    if ($row["RETIRADO"] == 1) {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=2&C=0&O=" . $idOferta . "&I=" . $row["ID"] . "'>Si</a></td>";
    } else {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=2&C=1&O=" . $idOferta . "&I=" . $row["ID"] . "'>No</a></td>";
    }
    if ($row["PAGO_VALIDADO"] == 1) {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=99&C=0&O=" . $idOferta . "&I=" . $row["ID"] . "'>Si</td>";
    } else {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=99&C=1&O=" . $idOferta . "&I=" . $row["ID"] . "'>No</td>";
    }
    echo "
      <td class='tablacentro'><a href='cambioestado.php?P=66&C=1&O=" . $idOferta . "&I=" . $row["ID"] . "' class='confirmacion'><img src='borrar.png' width='15px' alt='borrar'></a></td>";
  }
} else {
  echo "<tr>
    <td colspan='6'>Aun no hay pedidos</td>
    </tr>";
}

echo "</tbody>
<table>";


echo "<br/><a href='exportar.php?ID=" . $idOferta . "'><button style='background-color:#ffffff;'>Exportar a Excel</button></a>";

} else {
  echo "Error: Para hacer un editar las ofertas debe seleccionar una oferta.</BR>
  <a href='ofertas_master.php'>Ir a Administrador de Ofertas >></a>";
}

?>
<script>
window.onload=function(){
var pos=window.name || 0;
window.scrollTo(0,pos);
}
window.onunload=function(){
window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
}

var elems = document.getElementsByClassName('confirmacion');
var confirmIt = function (e) {
      if (!confirm('¿Estás segura que quieres borrar ese registro?')) e.preventDefault();
  };
  for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
    }
</script>




</tbody>
</table>

</html>
