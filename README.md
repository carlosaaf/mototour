# Moto Tour

## Descrição

Projeto criado para a cadeira de Seminãrios V da Uniasselvi utilizando PHP, HTML CSS e Javascript, sem qualquer framework para o entendimento dos conceitos de programação WEB apresentados na cadeira.

Para utilizar os conceitos aprendidos criamos um cadastro de passeios de motocicleta.

## Instalação

### MySQL

Utilizamos o banco de dados MySQL, onde é necessário criar um "database" chamado "mototour". Abaixo seguem os dados de conexão para esta base, mas que podem ser alterados no aruivo **src/util/config.php**.

* **Nome da Base:** mototour
* **Nome do Usuário:** mototour
* **Senha do Usuário:** password

```sql
CREATE DATABASE mototour;
CREATE USER 'mototour'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON mototour.* TO 'mototour'@'localhost';
```

Para criar as tabelas do banco dados basta executar o script create_database.sql que está no diretório script

```
mysql -u mototour -p < script/create_database.sql
```

Se desejar colocar alguns dados iniciais, execute o comando abaixo. Ele criará 3 passeios com dados fictícios.

```
mysql -u mototour -p < script/load_data.sql
```

### PHP

Para que o PHP possa acessar o MySQL, é necessário que a extensão do mysqli esteja ativa (descomentada) no arquivo de configuração (php.ini).

```
extension=mysqli
```

## Execução

O programa pode ser instalado em um servidor Apache com suporte ao PHP ou, para desenvolvimento, usar diretamente o comando abaixo. Este comando levanta um servidor php e considera o dirteório public como seu docroot, ou seja, onde o navegador vai buscar seus recursos.

```
php -S localhost:3000 -t public
```

## Estrutura do projeto

Quando o navegador acessa o projeto, ele vai carregar o fonte public/index,php. Este fonte dispara a execução do fonte src/app.php, que carrega os demais fonts php.

Os demais fontes php foram organizados em diretórios conforme sua função:

* **public**: este é o **docroot** do servidor, ou seja, os recursos nesta estrutura de diretórios são públicos (imagens, icones etc) e a página **index.php** que controla a exibição do php chamando o fonte php app.php que está na raiz do diretório **src**.

* **scripts**: armazenam scripts usados na instalação/manutenção do projeto.

* **src**: os fontes php que são apenas executados e não podem ser vistos diretamente via navegador. Nesta estrutura de diretório temos:

    * **controller**: fontes php responsáveis por gerar as páginas html com seu conteúdo

    * **model**: fontes php que fazem acesso ao banco de dados

    * **util**: fontes php diversos

## Conceitos utilizados no projeto

* **Barra de navegação**: comum a todas as páginas e implementado no fonte src/controller/page_controller.php

* **Rodapé**: coum a todas as páginas e implementado no fonte src/controller/page_controller.php

* **Cabeçalho de página**: implementado em cada controller, permitindo qu cada CRUD tenha cabeçalho específico

* **URLs amigáveis**: as urls ou caminho de acesso são virtuais, seguindo uma hierarquia conforme os recursos que o projeto disponibiliza. O fonte php src/util/router.php realiza a conversão das rotas virtuais em chamadas para o respectivo controller e as rotas são definidas no fonte php src/app.php.

    * / (raiz): página de entrada ou home

    * /tours: páginas que realizam o CRUD dos passeios

    * /riders: páginas que realizam o CRID dos amigos pilotos (ainda não implementado)

    * /motorcycles: página que realizam o CRUD das motocicletas (ainda não impklementado)

* **Ações padrão na URL**: cada ação do CRUD é feita conforme a url passada

    * GET /tours: lista os passeios

    * GET /tours/add: edita um novo passeio

    * GET /tours/{id}: mostra o passeio identificado pelo {id}, por exemplo, /tours/1 mostra o passeio com identificador 1

    * GET /tours/{id}/edit: edita o passeio identificado pelo {id}

    * GET /tours/{id}/delete: remove o passeio identificado pelo {id}, sendo que esta ação ainda não foi implementada por motivos de segurança

    * POST /tours/save: salva o passeio que vem no corpo da requisição, sendo que, se o id for zero um novo passeio é criado e se o id for maior que zero, o passeio com este id será modificado

    As ações add e edit mostram os dados para edição e, quando o botão Salvar na página é pressionado, o save é chamado para realizar o salvamento.

    No fonte src/app.php são definidas estas rotas, indicando o método do controller que será chamado.

* **Templates de página**: nos controllers existem trechos usando \<\<\< HTML ... HTML que criam o html que será exibido, sendo que nele existem trechos dentro de parênteses que serão substituídos pelo conteúdo de variáveis. o exemplo abaixo o resultado será "Meu nome é Beto.".

```
$nome = "Beto";

$result = <<<HTML
    <p>Meu nome é {$nome}.
    HTML;
```
