# pix-qrcode-copy-and-paste
Integração dinâmica para PSPs do PIX QRCode + Copia e Cola em CURL PHP.

É esse exemplo foi feito e testado usando as PSPs do Pagseguro e Gerencianet.

#integração
1 - Cadastro em uma PSP
2 - Eu utilizei a Pipefy (https://app.pipefy.com/) para solicitar o CLIENT_ID, CLIENT_SECRET e os certificados necessários para implementação. Basicamente você
    deve preencher um formulário vinculando a conta do seu PSP escolhido na Pipefy.
3 - Pipefy irá retornar por e-mail os dados necessários para usar essa integração com sucesso, também irão solicitar que você faça alguns testes e envie uns logs
    para eles, você pode usar a ferramenta Postman para gerar esses logs e encaminhar, após isso eles validam esses logs e te retornam o CLIENT_ID, CLIENT_SECRET
    e os certificados de produção.
    
    
#links de ajuda
Documentação que ensina como executar a integração.
https://documenter.getpostman.com/view/10863174/TVetc6HV?_ga=2.25106610.907642385.1661511887-2024143772.1654005611&_gl=1*1bmofi*_ga*MjAyNDE0Mzc3Mi4xNjU0MDA1NjEx*_ga_VZW8YVGM9B*MTY2MTUzODA0OC4yNS4xLjE2NjE1MzgzNTEuMC4wLjA.#3322de97-b3cc-453a-81a7-b3c2e34c8016

No vídeo abaixo você aprende a fazer os requests e gerar os logs para homologação.
https://www.youtube.com/watch?v=Ccovr59BR9M&list=PLhaUg08AKZJp53-sbS5IG1dLTmH5XLvce&index=1

Documentação do Pagseguro
https://dev.pagseguro.uol.com.br/reference/pix-intro
