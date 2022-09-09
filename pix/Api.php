<?php

class Api {

    /**
     * URL Base do PSP (requisição)
     * @var string
     */
    private $baseUrl;

    /**
     * Client ID do oAuth2 do PSP
     * @var string 
     */
    private $clientId;

    /**
     * Client secret do oAuth2 do PSP
     * @var string
     */
    private $clientSecret;

    /**
     * Caminho absoluto ate o arquivo do certificado
     * @var string
     */
    private $certificate;
    
    /**
     * Caminho absoluto ate o arquivo da key
     * @var string
     */
    private $key;

    /**
     * Define os dados iniciais da classe
     * @param string $baseUrl
     * @param string $clientId
     * @param string $clientSecret
     * @param string $certificate
     */
    public function __construct($baseUrl, $clientId, $clientSecret, $certificate, $key) {

        $this->baseUrl = $baseUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->certificate = $certificate;
        $this->key = $key;
    }

    /**
     * Método responsável por criar uma cobrança
     * @param array $txid
     * @param array $request
     */
    public function createCob($txid, $request) {

        return $this->send('PUT', 'instant-payments/cob/'.$txid,$request);
    }
    
    /**
     * Método responsável por obter o token de acesso as APIs Pix
     * @return string
     */
    private function getAccessToken(){
        
        //Endpoint completo
        $endpoint = $this->baseUrl.'pix/oauth2';
        
        //headers
        $headers = [
            'Content-type: application/json',
        ];
        
        //Corpo
        $request = [
            'grant_type' => 'client_credentials'
        ];
        
        //curl
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_USERPWD => $this->clientId.':'.$this->clientSecret,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request),
            CURLOPT_SSLCERT => $this->certificate,
            CURLOPT_SSLCERTPASSWD => '',
            CURLOPT_SSLKEY => $this->key,
            CURLOPT_SSLKEYPASSWD => '',
            CURLOPT_HTTPHEADER => $headers
        ]);
        
        //executa o curl
        $response = curl_exec($curl);
        curl_close($curl);
        
        //response em array
        $responseArray = json_decode($response , true);
        
        //retorna o access token
        return $responseArray['access_token'] ?? '';
    }
    
    /**
     * Método responsável por enviar requisições ao PSP
     * @param string $method
     * @param string $resource
     * @param request $resource
     * @param array $request
     */
    private function send($method, $resource, $request = []){
        
        //Endpoint completo
        $endpoint = $this->baseUrl.$resource;
        
        //header (cabeçalho)
        $headers = [
            'Cache-Control: no-cache',
            'Content-type: application/json',
            'Authorization: Bearer '.$this->getAccessToken()
        ];
        
        //curl
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSLCERT => $this->certificate,
            CURLOPT_SSLCERTPASSWD => '',
            CURLOPT_SSLKEY => $this->key,
            CURLOPT_SSLKEYPASSWD => '',
            CURLOPT_HTTPHEADER => $headers
        ]);
        
        switch ($method) {
            case 'POST':
            case 'PUT':
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
                break;
        }
        
        //executa o curl
        $response = curl_exec($curl);
        curl_close($curl);
        
        //retorna o array da resposta
        return json_decode($response, true);
        
    }

}
