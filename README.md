Jhekasoft Testform
==================

Installation
------------
```sh
php composer.phar install
```
```sh
php app/console doctrine:database:create
```

```sh
php app/console assets:install web
```

```sh
php app/console assetic:dump
```

```sh
php app/console doctrine:schema:update --force
```

Export
------

```sh
php app/console testform:export [email]
```

Link: /api/stream
