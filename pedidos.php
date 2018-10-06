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
<a href='ofertas.php'>< Volver</a></br>
<h1>Detalles de la Oferta:</h1>
<h3>Producto: " . $detOferta["NOMBRE"] . "</h3>
<p>Descripción: " . $detOferta["DESCRIPCION"] . "</p>
<p>Variedades: " . $detOferta["VARIEDADES"] . "</p>
<h3>Precio: $" . number_format($detOferta["PRECIO"],0,'','.') . "</h3>
<p>Fecha Inicio: " . date('d-M-Y', strtotime($detOferta["FECHA_I"])) . " / Fecha Término: ";
if ($detOferta["FECHA_C"] > "2018-01-01") {
    echo date('d-M-Y', strtotime($detOferta["FECHA_C"]));
  } else {
    echo "---";
  }
echo "<p>Pedido Mínimo: " . $detOferta["PED_MIN"] . " / Pedido Máximo: " . $detOferta["PED_MAX"] . "</p>";
$sql_pedido = "SELECT SUM(Cantidad) AS TotalPedidos FROM pedidos WHERE ID_OFERTA = $idOferta";
$sql_pedido1 = mysqli_query($conn, $sql_pedido);
$cantidad = mysqli_fetch_array($sql_pedido1);
if ($cantidad["TotalPedidos"] > 0) {
  echo "<p>Pedidos que llevamos hasta el momento: " . $cantidad["TotalPedidos"] . "</p>";
} else {
  echo "<p>Pedidos que llevamos hasta el momento: Sin Pedidos Aun</p>";
}

echo "<img src='" . $detOferta["IMAGEN"] . "' style='width: 100%; max-width:600px;' alt='Imagen con detalles de la oferta'>";


echo "<p><b>Pasos a seguir para hacer un pedido<b></br>
1 Ingrese su nombre, cantidad y variedad y luego presione 'Hacer Pedido'</br>
<b>2 No pague hasta quqe se indique en el chat que se ha cerrado la oferta y que debe pagar</b></br>
3 Una vez que pague/retire, vuelva a está página y presione sobre ese estado para cambiarlo</p>";

if ($detOferta["ACTIVA"] == 1) {
echo "<h1>Realizar Un Pedido</h1>
<form action='hacer_pedido.php' method='post'>
Nombre y Apellido: <input type='text' name='nombre'></BR>
Cantidad: <input type='text' name='cantidad'></BR>
Variedad: <input type='text' name='variedad'></BR>
<input type='hidden' name='idoferta' value='" . $idOferta . "'>
<input type='Submit' name='hacerpedido' value='Hacer Pedido'>
</form></BR>";
} else {
echo "<h1 style='color: red'>Oferta Finalizada o Aun no iniciada</h1>";
}

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
      echo "<td class='tablacentro'><a href='cambioestado.php?P=1&C=0&O=" . $idOferta . "&I=" . $row["ID"] . "''>Si</a></td>";
    } else {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=1&C=1&O=" . $idOferta . "&I=" . $row["ID"] . "''>No</a></td>";
    }
    if ($row["RETIRADO"] == 1) {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=2&C=0&O=" . $idOferta . "&I=" . $row["ID"] . "''>Si</a></td>";
    } else {
      echo "<td class='tablacentro'><a href='cambioestado.php?P=2&C=1&O=" . $idOferta . "&I=" . $row["ID"] . "''>No</a></td>";
    }
    if ($row["PAGO_VALIDADO"] == 1) {
      echo "<td class='tablacentro'>Si</td>";
    } else {
      echo "<td class='tablacentro'>No</td>";
    }
  }
} else {
  echo "<tr>
    <td colspan='6'>Aun no hay pedidos</td>
    </tr>";
}

echo "</tbody>
<table>";


} else {
  echo "Error: Para hacer un pedido primero debe seleccionar una oferta.</BR>
  <a href='ofertas.php'>Ir a Listado de Ofertas >></a>";
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
</script>

</tbody>
</table>

</html>
