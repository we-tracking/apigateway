## API DE INTEGRAÇÃO
---
Automatização de consulta e coleta de preços

### Requisitos
---
- Xampp php 8.1+
- composer

### Primeiros passos
---
Instale o Xampp ou qualquer software que executara o apache.

clone este repositorio no xampp/htdocs ou no diretorio que for emular apache.

altere as variaveis de ambiente (muito importante)
---
/.env:
````
####### ROTA #######
BASE_PREFIX=/wetracking` #nome da pasta do projeto, provavelmente vai ser essa mesma
APP_ROOT=C:\xampp\htdocs\wetracking # o caminho ate o repositorio

ENCODE=HS256 #esses encode sao utilizados para gerar a jwt
APP_KEY=hsdashdkjashdjkasd # esta app key tbm

````

execute o comando: 
```
    composer update
````

rode as migrations: 
```
    php wt migrate
````

rode as seeds: 
```
    php wt seeds
````