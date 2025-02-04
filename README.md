# Showcase REST API - PHP

## Task description

1. receives HTTP POST requests only on a "/track" route
   - gets data in JSON format passed in the request body
   - saves the JSON data into a local file (append)
   - if the data contains a "count" parameter, the application increments the value of the "count" key by the value of the 'count' parameter in a Redis database
2. receives HTTP GET requests only on a "/count" route
   - returns the value of the "count" key from the Redis database

### Features

apart from the above-mentioned requirements

- ✅ Slim framework
- ✅ Extensive unit tests
- ✅ PHPStan max level
- ✅ Coding standards
- ✅ Error handling
- ✅ Error logging to file
- ✅ JSON input to PHP classes mapping
- ✅ Docker for convenient team development
- ✅ Easy to change count storage implementation
- 🚧 **Coming Soon** 🚧 Easy to change Request data storage implementation
    
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

```
    http://localhost:8081/
```

### Configuration

rewrite default config by creating `config-local.json` file in `/app/config`. Use `/config-local.json.dist` as a template.

```
    cp config-local.json.dist ./app/config/config-local.json
```

## Deployment to production

- set app.show_error_details to false in config-local.json file in production
- redis must not be set up in docker container on server. Failed container would cause data loss. Configure connection
to redis in configuration file accordingly.

## API

in local development, the application is receiving request on url `http://localhost:8081/`.

- the API documentation can be managed using OpenAPI, when the application grows
- use i.e. Postman application to send requests

### GET "/count"

returns value of "count" key in redis

### POST "/track"

receives "application/json" requests and stores content in `/storage/tracking-file`.
If "count" parameter is present, it increments value of "count" key in redis.

The route simulates strictly typed/organized json.

- extra unexpected parameters will cause Err 400
- missing required parameters will cause Err 400

#### Example json string - all supported parameters 

```
{
    "id": 22, 
    "count": 2,
    "requiredString": "required-string",
    "optionalStatistic": {
        "name": "name",
        "value": 250
    }
}
```

curl command for running from terminal:

```
curl -X POST http://localhost:3000/track -H "Content-Type: application/json" -d '{
"id": 2,
"count": 99,
"content": "some content",
"whatever": "whatever"
}'
```

#### Example json string - required parameters only

```
{
    "id": 22, 
    "requiredString": "required-string",
}
```

curl command for running from terminal:

```
curl -X POST http://localhost:3000/track -H "Content-Type: application/json" -d '{
  "id": 2,
  "whatever": "whatever"
}'
```
