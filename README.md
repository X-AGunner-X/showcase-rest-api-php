# Showcase REST API - PHP

## Local development

### Building up the app

build your docker containers in root folder of the project

```
    docker-compose up -d --build
```

install composer dependencies

```
    docker-compose exec app composer install
```

application is waiting fo requests on url (port may differ, check `/docker-compose.yml` in case of problems)

    http://localhost:8081/

### Configuration

rewrite default config by creating `config-local.json` file in `/app/config`. Use `/config-local.json.dist` as a template.

```
    cp config-local.json.dist ./app/config/config-local.json
```
