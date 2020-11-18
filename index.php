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

date_default_timezone_set("America/Sao_Paulo");

$full_start = microtime(TRUE);
# Só são permitidos PDFs
$allowedMimes = array('pdf' => 'application/pdf');
$messages = array();

?>

<html>
    <link href="https://cdn.rawgit.com/h-ibaldo/Raleway_Fixed_Numerals/master/css/rawline.css" rel="stylesheet"> 
    <link rel="stylesheet" href="uploadInternacional.css">
    <div class="wrapper">
        <section class="details-group">
            <div class="validation-result">
              Arquivo de assinatura <b>aprovado</b> em conformidade com as raízes oficiais dos países da América Latina e Caribe, conforme padrões internacionais.
            </div>

            <div class="signer-info-container">
              <div class="signer-info">
                <div class="signer-info-key">Nome do arquivo: &nbsp;</div>
                <div class="signer-info-value">
                  <?php echo $fileName ?>
                </div>
              </div>
              <div class="signer-info">
                  <div class="signer-info-key">Data de verificação:&nbsp; </div>
                  <div class="signer-info-value">
                  <?php echo $verificationDate ?>
                  </div>
                </div>
              <div class="signer-info">
                <div class="signer-info-key">Versão do software:&nbsp; </div>
                <div class="signer-info-value">
                <?php echo $softwareVersion ?>
                </div>
              </div>
            </div>
            
            <?php if(is_array($signatures)) : ?>
              <?php foreach($signatures as $sig): ?>
                <details class="details">
              <summary class="details__summary">
                <b>Assinado por:</b> <?php echo $sig->certification->signer->subjectName ?>
                </summary>
                    <div class="signer-container">
                      <details class="details" open>
                        <summary class="summary-information">
                          Informações da assinatura
                        </summary>
                        <div class="signer-info-container">
                          <div class="signer-info">
                            <div class="signer-info-key">Status da assinatura:&nbsp; </div>
                            <div class="signer-info-value">
                            <?php echo $sig->certification->signer->validSignature ?>
                            </div>
                          </div>
                          <div class="signer-info">
                              <div class="signer-info-key">Caminho de certificação:&nbsp; </div>
                              <div class="signer-info-value">
                              <?php 
                                if($sig->certification->signer->certPathValid=="Valid") echo "Válido";
                                else echo "Inválido";
                              ?>
                              </div>
                            </div>
                          <div class="signer-info">
                            <div class="signer-info-key">
                              Cifra assimétrica:&nbsp; 
                            </div>
                            <div class="signer-info-value">
                            <?php 
                              if($sig->integrity->asymmetricCipher) echo "Aprovada";
                              else echo "Reprovada";
                            ?>
                            </div>
                          </div>
                        </div>
                      </details>
                      </div>
                      <details class="details">
                        <summary class="summary-information">
                          Caminho de certificação
                        </summary>
                        <div class="signer-container">
                          <?php foreach ($sig->certification->signer->certificate as $cert): ?>
                          <details class="details" open>
                            <summary class="summary-information" open>
                            <?php echo $cert->subjectName ?>
                            </summary>
                            <div class="signer-info-container">
                              <div class="signer-info">
                                  <div class="signer-info-key">
                                    Assinatura:&nbsp;
                                  </div>
                                  <div class="signer-info-value">
                                    <?php 
                                    if($cert->validSignature) echo "Aprovada";
                                    else echo "Reprovada";
                                    ?>
                                  </div>
                                </div>
                              <div class="signer-info">
                                <div class="signer-info-key">
                                  Aprovado a partir de:&nbsp;
                                </div>
                                <div class="signer-info-value">
                                <?php echo $cert->notBefore ?>
                                </div>
                              </div>
                              <div class="signer-info">
                                <div class="signer-info-key">
                                  Aprovado até:&nbsp;
                                </div>
                                <div class="signer-info-value">
                                <?php echo $cert->notAfter ?>
                                </div>
                              </div>
                            </div>
                          </details>
                          <?php endforeach  ?>
                          </div>
                      </details>
                  </details>
                <?php endforeach ?>
                <?php elseif(isset($signatures)): ?>
                  <details class="details">
              <summary class="details__summary">
                <b>Assinado por:</b> <?php echo $signerName ?>
                </summary>
                    <div class="signer-container">
                      <details class="details" open>
                        <summary class="summary-information">
                          Informações da assinatura
                        </summary>
                        <div class="signer-info-container">
                          <div class="signer-info">
                            <div class="signer-info-key">Status da assinatura:&nbsp; </div>
                            <div class="signer-info-value">
                            <?php echo $validSignature ?>
                            </div>
                          </div>
                          <div class="signer-info">
                              <div class="signer-info-key">Caminho de certificação:&nbsp; </div>
                              <div class="signer-info-value">
                              <?php 
                                if($certPathValid=="Valid") echo "Válido";
                                else echo "Inválido";
                              ?>
                              </div>
                            </div>
                          <div class="signer-info">
                            <div class="signer-info-key">
                              Cifra assimétrica:&nbsp; 
                            </div>
                            <div class="signer-info-value">
                            <?php 
                              if($asymmetricCipher) echo "Aprovada";
                              else echo "Reprovada";
                            ?>
                            </div>
                          </div>
                        </div>
                      </details>
                      </div>
                      <details class="details">
                        <summary class="summary-information">
                          Caminho de certificação
                        </summary>
                        <div class="signer-container">
                          <?php foreach ($certs as $cert): ?>
                          <details class="details" open>
                            <summary class="summary-information" open>
                            <?php echo $cert->subjectName ?>
                            </summary>
                            <div class="signer-info-container">
                              <div class="signer-info">
                                  <div class="signer-info-key">
                                    Assinatura:&nbsp;
                                  </div>
                                  <div class="signer-info-value">
                                    <?php 
                                    if($cert->validSignature) echo "Aprovada";
                                    else echo "Reprovada";
                                    ?>
                                  </div>
                                </div>
                              <div class="signer-info">
                                <div class="signer-info-key">
                                  Aprovado a partir de:&nbsp;
                                </div>
                                <div class="signer-info-value">
                                <?php echo $cert->notBefore ?>
                                </div>
                              </div>
                              <div class="signer-info">
                                <div class="signer-info-key">
                                  Aprovado até:&nbsp;
                                </div>
                                <div class="signer-info-value">
                                <?php echo $cert->notAfter ?>
                                </div>
                              </div>
                            </div>
                          </details>
                          <?php endforeach  ?>
                          </div>
                      </details>
                  </details>
              <?php endif ?>
             

              <?php if(is_array($notIcpbrSignature)) : ?>
              <?php foreach($notIcpbrSignature as $notIcp): ?>
                <details class="details">
              <summary class="details__summary">
                <b>Assinado por:</b> <?php echo $signerName ?>
                </summary>
                    
                <?php endforeach ?>
                <?php elseif(isset($notIcpbrSignature)): ?>
                  <details class="details">
              <summary class="details__summary">
                <b>Assinado por:</b> <?php echo $notIcpbrSubjectName ?>
                </summary>
                    
              <?php endif ?>

              
        </section>
      </div>
</html>