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
<a href='ofertas_master.php'>< Volver</a></br>
<h1>Editar Oferta</h1>

<?php
// archivo de conexion a la bd
include("conexion.php");

//recolectar datos GET
if (isset($_GET['ID'])) {
	$idOferta = $_GET['ID'];

// obtener los detalles de la oferta
mysqli_set_charset($conn,"utf8");
$sql_oferta = "SELECT * FROM ofertas WHERE ID = $idOferta";
$sql_oferta1 = mysqli_query($conn, $sql_oferta);
$detOferta = mysqli_fetch_array($sql_oferta1);

echo "
<form action='oferta_enviar.php' method='post' enctype='multipart/form-data'>
<h3>Título:</h3>
<input type='text' name='nombre' value='" . $detOferta["NOMBRE"] . "'>
<p>Variedades (separar con un / )</p>
<input type='text' name='variedades' value='" . $detOferta["VARIEDADES"] . "'>
<p>Descripción</p>
<textarea style='height: 100px; width: 70%;' name='descripcion'>" . $detOferta["DESCRIPCION"] . "</textarea>
<p>Imagen</p>
<img src='" . $detOferta["IMAGEN"] . "' alt='imagen oferta' style='width: 100%; max-width:600px;'>
<p>Cambiar Imagen</p>
<input type='file' name='fileToUpload' id='fileToUpload'>
<p>Precio (Sin Puntos)</p>
<input type='text' name='precio' value='" . $detOferta["PRECIO"] . "'>
<p>Fecha de Inicio</p>
<input type='date' name='fecha_i' value='" . $detOferta["FECHA_I"] . "'>
<p>Fecha de Termino</p>
<input type='date' name='fecha_c' value='" . $detOferta["FECHA_C"] . "'>
<p>Pedido Mínimo</p>
<input type='number' name='ped_min' value='" . $detOferta["PED_MIN"] . "'>
<p>Pedido Máximo</p>
<input type='number' name='ped_max' value='" . $detOferta["PED_MAX"] . "'></br>
<input type='hidden' name='id' value='" . $idOferta . "'>
<input type='Submit' name='modificar' value='Modificar'>";

} else {
  echo "Error: Para editar una oferta primero debe seleccionar una oferta.</BR>
  <a href='ofertas_master.php'>Ir a Administrador de Ofertas >></a>";
}

?>
</script>

</tbody>
</table>

</html>
