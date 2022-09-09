<?php

//Chama a classe contendo os métodos para criação da cobrana e do payload (código e qrcode pix).
require_once './pix/Api.php';

//estancia a api
$obApiPix = new Api("https://secure.sandbox.api.pagseguro.com/", "client_id", "client_secret", __DIR__ . '/files/certificates/certificado.pem', __DIR__ . '/files/certificates/key.key');

//monta o request da cobrança
$request = [
    'calendario' => [
        'expiracao' => 3600
    ],
    'devedor' => [
        'cpf' => '12345678909',
        'nome' => 'Maria da Silva'
    ],
    'valor' => [
        'original' => '100.00'
    ],
    'chave' => '12345678909',
    'solicitacaoPagador' => 'Pagamento do pedido 123'
];

//cria uma cobrança
$response = $obApiPix->createCob("FSA1324567890000000000000002", $request);

//valida caso não consiga gerar o pix
if(!isset($response['location'])){
    
    echo "Problemas ao gerar o pix, tire uma print e contate a administração";
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    exit;
}
?>
<html>
    <head>
        <title>PIX qrCode + Copia e COla Dinâmico</title>
    </head>
    <body>
        <h3>QRCode Pix</h3>
        <!--<img src="<?php // echo (new QRCode)->render($payloadQrCode); ?>" alt="QRCode Pix" width="300" />-->
        <img src="<?php echo $response['urlImagemQrCode']; ?>" alt="QRCode Pix" width="300" />
        
        <h3>Código Pix</h3>
        <?php // echo $payloadQrCode; ?>
        <?php echo $response['pixCopiaECola']; ?>
    </body>
</html>

