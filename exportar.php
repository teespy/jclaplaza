<?PHP
  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  // archivo de conexion a la bd
  if (isset($_GET['ID'])) {
  	$idOferta = $_GET['ID'];

  include("conexion.php");

  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);

    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "oferta" . $idOferta . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $sql_exportar = "SELECT * FROM pedidos WHERE ID_OFERTA = $idOferta AND ELIMINADO != 1";
  $sql_exportar1 = mysqli_query($conn, $sql_exportar);
    while ($row = mysqli_fetch_assoc($sql_exportar1)) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;
} else {
  echo "Error";
}
?>
