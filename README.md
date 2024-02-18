## Project Main APIGateway
This software was developed with the purpose of being an API gateway and automating processes using RPA concepts with its own framework. It was developed for the final course project of computer cience.

## Quick Start
---
```bash
# copy .env
    cp .env.example .env
# build docker image
    docker-compose build
# run container as robot
    docker-compose up -d
# updae dependencies
    docker-compose exec app composer update
# run migrations and seed databse
    docker-compose exec app php framework migration:up --seed
```
## RPA Execution
---
The automation proccessing is based on queue, so you will need to start rabbitMQ listening port.
 ```bash
    docker-compose exec app php framework event:listen
 ```

Then put all active products to process with:
``` bash
    docker-compose exec app php framework run:rpa-proccess
```

## Extra
---

```bash
# to see all commands enabled run:
    docker-compose exec app php framework

# to down all migration run:
    docker-compose exec app php framework migration:down

# to down a especific version run:
    docker-compose exec app php framework migration:down --version=123NameOfYourVersion
```