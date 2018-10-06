<?php
include("conexion.php");
mysqli_set_charset($conn,"utf8");

// obtener los datos del post y limpiarlos
$datos = array("nombre", "variedades", "descripcion", "precio", "fecha_i", "fecha_c", "ped_min", "ped_max", "activo");
foreach ($datos as $dato) {
  ${$dato} = $_POST[$dato];

  ${$dato} = stripslashes(${$dato});
  ${$dato} = mysqli_real_escape_string($conn, ${$dato});
}

// obtener la imgen si se sube archivo

$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["modificar"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "<script language='javascript'>alert('Imagen subida, tipo: " . $check["mime"] . "');</script>";
        $uploadOk = 1;
    } else {
        echo "<script language='javascript'>alert('Error, el archivo seleccionado no es una imagen valida');</script>";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "<script language='javascript'>alert('Error, ya existe una imagen con ese nombre');</script>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<script language='javascript'>alert('Error, la imagen es demasiado grande, máximo 500 kb.');</script>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<script language='javascript'>alert('Error, Solo se permiten archivos JPG, JPEG, PNG y GIF.');</script>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<script language='javascript'>alert('Lo sentimos, el archivo no fue subido');</script>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $imagen = "img/" . basename( $_FILES["fileToUpload"]["name"]);
    } else {
        echo "<script language='javascript'>alert('Error');</script>";
    }
}

$sql_nueva_oferta = "INSERT INTO ofertas (NOMBRE, VARIEDADES, DESCRIPCION, PRECIO, FECHA_I, FECHA_C, PED_MIN, PED_MAX, IMAGEN, ACTIVA) VALUES ('$nombre', '$variedades', '$descripcion', '$precio', '$fecha_i', '$fecha_c', '$ped_min', '$ped_max', '$imagen', '$activo')";

if ($conn->query($sql_nueva_oferta) === TRUE) {

  echo "<script language='javascript'>alert('Oferta agregada');window.location='ofertas_master.php'</script>";

// agregar javascrip de aviso de realizado
} else {
  echo "error" . mysqli_error($conn);
}

?>
