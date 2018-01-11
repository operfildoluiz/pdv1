# PDV1
PDV1 é um projeto sistema de controle de Pedidos de Venda desenvolvido como desafio para o processo seletivo da DB1 Global Software.

> **Proposta**
Elaborar um sistema capaz de manter clientes, produtos e pedidos. O stack deve conter Symfony com Doctrine no back-end, banco de dados MySQL, Bootstrap no front-end e testes com PHPUnit.

## Desenvolvimento
### Ambiente
O sistema foi desenvolvido em ambiente Linux, servidor Apache (testado em Nginx). A versão do PHP é a 7.0. O sistema também utiliza o Node para executar tarefas (através do npm) em ambiente de desenvolvimento com o Gulp.js (npm versão 5.5.1)

### Back-end
O PDV1 foi construído utilizando Symfony 4 com Doctrine 2. Pareceu adequado para o porte do projeto seguir o padrão MVC com Repositórios, respeitando as regras SOLID e KISS.

### Front-end
O sistema utiliza o Gulp como compilador SASS e Javascript e faz uso de um tema gratuito, o Light Bootstrap, oferecido através da licença MIT pela @CreativeTim no repositório [creativetimofficial/light-bootstrap-dashboard](https://github.com/creativetimofficial/light-bootstrap-dashboard).

Na seção de pedidos, utilizou-se jQuery na versão mais atualizada.

### Testes
O PHPUnit é a biblioteca que melhor se adequa a projetos Symfony, por isso pareceu mais adequado utilizá-la. Os testes podem ser executados através do comando `./bin/phpunit` na raíz do projeto, após a instalação do projeto.

## Como instalar

Primeiro, clone o repositório e acesse a pasta raíz do projeto.

Depois, instale as dependências através do Composer:

    composer install

É possível setar o banco de dados através dos comandos do Symfony. Porém, no diretório `project/` há um arquivo `schema.sql` com a estrutura do banco de dados.

Configure o arquivo `.env` com as credenciais de acesso do banco de dados. Ex:

    ...
    DATABASE_URL=mysql://root:senha123@127.0.0.1:3306/pdv1
    ...

Inicie o servidor built-in do PHP através do comando:

    php -S localhost:8080 -t public/
