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
#Pegando as assinaturas
$signatures = $decodedData->report->signatures->signature;
if($signatures[1]){
  for($j = 0; $j < sizeof($signatures);$j++){
    console_log($signatures[$j]);
  }
  foreach ($signatures as $signature) {
    console_log($signature);
  }
}


?>