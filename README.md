# Project Developer

O `Project Developer` é um sistema onde é possivel cadastrar desenvolvedores e seus nivéis técnicos e lista eles em um aplicação web.

## Tecnologias

- PHP
- Laravel
- MySQL
- Docker
- Docker Compose
- Angular

## ADR

Acho que a melhor forma de explicar o projeto é através dos ADRs (Architectural Decision Records), que são documentos que capturam uma decisão arquitetural feita em um projeto.

### ADR 1: Backend

O backend foi desenvolvido em PHP com o framework Laravel, foi escolhido o Laravel por ser um framework robusto e com uma curva de aprendizado baixa, além de ser um dos frameworks mais utilizados no mercado.

Como o Laravel é um framework que segue o padrão MVC, acaba não sendo necessário aplicar Design System muito complexos para um projeto de poucos domínios. Por causa disso, optei por separar os domínios em pastas e especificar as regras de negócio em cada uma delas.

Sabemos que o DDD vai muito além de separar as regras de negócio em pastas, mas para um projeto pequeno como esse, acredito que seja suficiente.

Mesmo sabendo que o Eloquent acaba sendo incorporado ao domínio, optei por criar um repositório para cada domínio, para que seja possível trocar o ORM sem afetar a regra de negócio.

Para autenticaçao utilizei o Sanctum por ser o mais conhecido, porém sei da utilidade do Breeze e do Passport e quando usar cada uma dessas ferramentas.

O retorno dos endpoints foram padronizados por um Trait para não precisar ficar repetindo o código em todos os controllers. Nesse caso achei mais interessante usar esse caminho do que criar um Transformer, como antigamente, ou usar os Resources, como é feito atualmente.

Em momentos de consultas mais críticas, optei por usar o DB Transaction para garantir a integridade dos dados.


### ADR 2: Frontend

O frontend foi desenvolvido em Angular, e foi escolhido por ser um framework que eu menos trabalhei.

Utilizei ele para demonstrar a minha capacidade de estudo e de se adaptar a diferentes tecnologias.

O frontend foi separado em módulos, para que seja possível adicionar novas funcionalidades sem afetar o que já foi feito.

A estilização foi usando somente CSS, pois está bem simples.

### ADR 3: Banco de Dados

O banco de dados escolhido foi o MySQL, por ser um dos mais utilizados no mercado e por ser um banco de dados relacional e fazer mais sentido nesse projeto.

A modelagem do banco de dados foi feita de acordo com o que foi pedido no desafio.

## Documentaçao dos endpoints

A documentação da API está em `doc/Developers Project.md`.

Dentro da pasta `doc` tem um arquivo da collection do Postman para facilitar os testes.

## Como rodar os testes

Acesse o container via bash e rode o comando `php artisan test` para rodar os testes.

Para acessar o container, rode o comando `docker-compose exec backend bash`.

## Como rodar o frontend

Acesse o projeto e rode o comando `npm install` para instalar as dependências.

Depois rode o comando `ng serve` para subir o projeto ou `npm start` para subir o projeto.

Você pode rodar  com docker seguinte a documentação mais abaixo.

## Como rodar o backend

O Starter Kit usado foi o Laravel Sail, por ser o mais atualizado e com todas as configuraçoes.

Para começar um projeto com Sail, digite no terminal: `curl -s "https://laravel.build/backend?with=mysql,redis" | bash`

Para rodar o projeto, basta digitar `./vendor/bin/sail up` no terminal.

Mas antes, é necessário configurar o arquivo `.env` com as informações do banco de dados.

Para facilitar rodar o projeto, eu criei algumas configurações no arquivo `docker-compose.yml` para facilitar a execução do projeto.

Rode o comando `docker-compose up --force-recreate --remove-orphans --build` para subir o projeto.

O `force-recreate` é para forçar a recriação dos containers, o `remove-orphans` é para remover os containers que não estão sendo usados e o `build` é para reconstruir as imagens.

Isso não é obrigatório, mas ajuda a manter o ambiente limpo e caso onde se roda muitos containers, é bom para liberar espaço.

Caso queria rodar o projeto completo, siga a documentação abaixo.

## Como rodar o projeto

Ao clonar o projeto, é necessário rodar o comando `docker-compose up --force-recreate --remove-orphans` para subir o projeto.

O `force-recreate` é para forçar a recriação dos containers, o `remove-orphans` é para remover os containers que não estão sendo usados.

As imagens do projeto estão no Docker Hub, então não é necessário rodar o comando `docker-compose build`.

## Hospedagem do projeto

O backend desse projeto está hospedado na Digital Ocean no endereço `http://104.248.225.85`

## Pipeline

O pipeline do projeto está no Github Actions e está configurado para rodar os testes do backend toda vez que uma PR é aberta ou PUSH é feito.
