# CONTROLE DE PRODUTOS

Este projeto constitui o back-end da aplicação Controle de Produtos.

## Documentação da API no Postman

[Documentacao](https://documenter.getpostman.com/view/5876341/SWE57eXc?version=latest)

## Starting the project

Nos próximos tópicos descrevemos os requisitos e etapas para colocar a API em funcionamento.

### Prerequisite

Para a aplicação rodar na sua máquina é necessário que tenha o [Docker](https://www.docker.com/) instalado com a seguinte versão:

- Docker: version 18.03.1-ce
- Docker compose: version 1.21.2

É importante salientar que as portas **8080**, **3306**, não deverão está em uso no momento que os containeires forem ligados.

### Running

Depois de verificado a instalação do Docker em sua máquina, clone o projeto, o qual contém o projeto

```
cd controle_produtos/
```

Conceda permissão de execução para o script que irá iniciar os containers, criar o banco e dar migrate nas tabelas:

```
sudo chmod +x ./docker-run.sh
```

Finalmente, execute o script:
```
./docker-run.sh
```

Pronto! O projeto já deve está funcionando no [http://localhost:8080/](http://localhost:8080/).

Depois de instalado, você pode iniciar os containers da seguinte forma:
```
docker-compose up -d
```

E parar os containers:
```
docker-compose stop
```

## Built With

* [Docker](https://www.docker.com/) - Utilizar os containers
* [Laravel](https://laravel.com) - Framework utilizado
* [PostgreSQL](https://www.postgresql.org/) - Banco utilizado

## Autores

* **Victor Nunes** - [github](https://github.com/victornunes139)