<?php 

# Imprime $data no console do navegador
function console_log($data)
{
  echo '<script>';
  echo 'console.log(' . json_encode($data) . ')';
  echo '</script>';
}

# Get do json local
$jsonData = file_get_contents("./report.json");
if ($jsonData === false) {
    console_log("Não foi possível ler o arquivo!");
}

?>