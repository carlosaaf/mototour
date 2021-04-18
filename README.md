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

### PHP

Para que o PHP possa acessar o MySQL, é necessário que a extensão do mysqli esteja ativa (descomentada) no arquivo de configuração (php.ini).

```
extension=mysqli
```

## Execução

O programa pode ser instalado em um servidor Apache com suporte ao PHP ou, para desenvolvimento, usar diretamente o comando abaixo.

```
php -S localhost:3000 -t public
```
