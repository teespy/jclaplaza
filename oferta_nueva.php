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
<h1>Oferta Nueva</h1>
<?php
echo "
<form action='oferta_nueva_enviar.php' method='post' enctype='multipart/form-data'>
<h3>Título:</h3>
<input type='text' name='nombre' value='.'>
<p><b>¿Activo? (Luego se puede activar desde el menú)</b></p>
<input type='radio' name='activo' value='1' checked>Activo / <input type='radio' name='activo' value='0'>Inactivo <br/>
<br/>
<p>Variedades (separar con un / )</p>
<input type='text' name='variedades' value=''>
<p>Descripción</p>
<textarea style='height: 100px; width: 70%;' name='descripcion'>.</textarea>
<p>Imagen</p>
<input type='file' name='fileToUpload' id='fileToUpload'>
<p>Precio (Sin Puntos)</p>
<input type='text' name='precio' value='0'>
<p>Fecha de Inicio</p>
<input type='date' name='fecha_i' value=" . date("Y-m-d") . ">
<p>Fecha de Termino <span style='font-size: 10px:'>(Si no tiene fecha de termino, poner 1-1-0001)</span></p>
<input type='date' name='fecha_c' value='00001-01-01'>
<p>Pedido Mínimo</p>
<input type='number' name='ped_min' value='0'>
<p>Pedido Máximo <span style='font-size: 10px:'>(Si no hay máximo, dejar en 0)</span></p>
<input type='number' name='ped_max' value='0'></br>
<input type='Submit' name='modificar' value='Crear nueva oferta'>";

?>
</script>

</tbody>
</table>

</html>
