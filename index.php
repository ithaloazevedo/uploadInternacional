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

#Pegando assinaturas notIcpbr
$notIcpbrSignature = $decodedData->report->signatures->notIcpbrSignature;
console_log($notIcpbrSignature);
$notIcpbrSubjectName = $decodedData->report->signatures->notIcpbrSignature->certification->signer->subjectName;

# Pegando os certificados
if(is_array($signatures)) {
  foreach($signatures as $sig) {
    array_push($certs, $sig->certification->signer->certificate);

  }
}
elseif(isset($signatures)) {
  $certs = $decodedData->report->signatures->signature->certification->signer->certificate;
  console_log($certs);
  for($i = 0; $i < sizeof($certs);$i++){
      console_log($certs[$i]);
  }
  foreach ($certs as $cert) {
      console_log($cert);
  }
}

#Variáveis
$verificationDate = $decodedData->report->date->verificationDate; #data de verificação
$fileName = $decodedData->report->software->sourceFile; #nome do arquivo
$softwareVersion = $decodedData->report->software->version; #versão do software
$validSignature = $decodedData->report->signatures->signature->certification->signer->validSignature; #validade das assinaturas
$signerName = $decodedData->report->signatures->signature->certification->signer->subjectName; #Nome assinatura
$certPathValid = $decodedData->report->signatures->signature->certification->signer->certPathValid;
$asymmetricCipher = $decodedData->report->signatures->signature->integrity->asymmetricCipher;

?>