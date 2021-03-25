# test-frontend-api

Este é uma API simples para possibilitar o desenvolvimento de frontend. Trata-se de um CRUD simples de cadastro de Pets. Há uma tabela de tipos de Pet, que deverão ser exibidos em um select no formulário principal dos Pets.

Após clonar este repositório, entre na pasta do projeto e digite:

docker-compose up -d --build
docker-compose exec web composer install

Abaixo, a documentação da comunicação com a API. Se preferir, utilize o Postman: https://documenter.getpostman.com/view/695853/TzCHApzc

# Pet Type Collection
## Create Pet Type [POST]
### Request: http://localhost:8080/pets-type
### Body
{
    "name":"Cachorro"
}
### Response (201)
{
    "status": "Tipo de Pet salvo com sucesso!"
}
## List Pet Type [GET]
### Request: http://localhost:8080/pets-type
### Response (200)
[
    {
        "id": 1,
        "name": "Cachorro"
    },
    {
        "id": 2,
        "name": "Gato"
    }
]
## Get one Pet Type [GET]
### Request: http://localhost:8080/pets-type/{id}
### Response (200)
{
    "id": 1,
    "name": "Cachorro"
}
## Update Pet Type [PUT]
### Request: http://localhost:8080/pets-type/{id}
### Body
{
    "name":"Cão"
}
### Response (200)
{
    "id": 1,
    "name": "Cão"
}
## Delete Pet Type [DELETE]
### Request: http://localhost:8080/pets-type/{id}
### Response (204)

# Pet Collection
## Create Pet [POST]
### Request: http://localhost:8080/pets
### Body
{
    "type": 1,
    "name": "Tob",
    "owner": "Maria",
    "race": "Collie"
}
### Response (201)
{
    "status": "Pet salvo com sucesso!"
}
## List Pet Type [GET]
### Request: http://localhost:8080/pets
### Response (200)
[
    {
        "id": 1,
        "type": 1,
        "name": "Tob",
        "owner": "Maria",
        "race": "Collie"
    },
    {
        "id": 2,
        "type": 2,
        "name": "Purú",
        "owner": "Nabuco",
        "race": "Angorá"
    },
    {
        "id": 3,
        "type": 3,
        "name": "Piu-piu",
        "owner": "Joaquim",
        "race": "Pardal"
    }
]
## Get one Pet Type [GET]
### Request: http://localhost:8080/pets/{id}
### Response (200)
{
    "id": 2,
    "type": 2,
    "name": "Purú",
    "owner": "Nabuco",
    "race": "Angorá"
}
## Update Pet Type [PUT]
### Request: http://localhost:8080/pets/{id}
### Body
{
    "race": "Siames"
}
### Response (200)
{
    "id": 2,
    "type": 2,
    "name": "Purú",
    "owner": "Nabuco",
    "race": "Siames"
}
## Delete Pet Type [DELETE]
### Request: http://localhost:8080/pets/{id}
### Response (204)
