## Imagem

![alt text](https://github.com/d8web/projetoLoja/blob/main/public/assets/images/screenshoot.png)

## Instalação
Você pode clonar este repositório OU baixar o .zip

Ao descompactar, é necessário gerar o *autoload* para o **composer**.

Vá até a pasta do projeto, pelo *prompt/terminal* e execute:
> composer install

Depois é só aguardar.

## Configuração
Todos os arquivos de **configuração** e aplicação estão dentro da pasta *src*.

As configurações de Banco de Dados e URL estão no arquivo *src/Config.php*

É importante configurar corretamente a constante *BASE_DIR*:
> const BASE_DIR = '/**PastaDoProjeto**/public';

## Uso
Você deve acessar a pasta *public* do projeto.

## Database

Copiar o arquivo loja.sql no banco de dados e configurar em *src/Config.php*
Importar o arquivo sql no seu banco de dados.