# docker-compose-laravel (Volopa project)

## Usage

- `docker-compose up -d --build`.
- `docker-compose run --rm composer install`
- `docker-compose run --rm key:generate `
- `docker-compose run --rm migrate:refresh --seed`

## Env
copy env.example and set the correct database credentials

````
MYSQL_PORT=3308
MYSQL_DB=volopa
MYSQL_USER=volopa
MYSQL_PASSWORD=secret
````

## Testing

```
docker-compose run --rm php ./vendor/bin/phpunit
```

## Google Api 
you need to add GOOGLE_API key to .env (this can be found in the zip file)

## Endpoints
#### Get all tickets
``
Get /api/tickets
``

#### Create new ticket
``
Post /api/etickets
``

#### Delete ticket
``
Delete /api/ticket/[id]
``

### Search for ticket by first name or last name
``
Get /api/tickets/search/{name}
``

### Sort result 
``
Get /api/tickets/sort/{filter}
``

### Filter result
``
Post /api/tickets/filters/
``

### Extra 
Built a quick package `nour/filter` to filter result by passing any column name to the endpoint.

### xdebug

for phpstorm you will need to map the project `src` to `/var/www/html` in the server tab