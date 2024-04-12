# SAÉ S4.A.01 Développement d'application / Serveur API

### Les commandes à effectuer pour que le projet soit fonctionnel :

```shell
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan migrate:fresh
php artisan db:seed
# dans un terminal
php artisan serve
# dans un autre terminal s'il y a des jobs à traiter
php artisan queue:work
# dans un autre terminal, lancez l'outil de messagerie si il y a des mails transmis
mailpit
```

### Utiliser Docker et docker-compose

Pour déployer facilement notre application, vous pouvez utiliser `docker-composer.yml` avec la commande : 

```shell
docker-compose up
```

Nous avons utilisé **Docker Compose** pour utiliser en parallèle **Mailpit** (nous n'avons pas réussi à utilise **Docker Multi-Stage**).

La commande va utiliser `Dockerfile` pour produire le conteneur pour l'API. Ensuite, le conteneur **Mailpit** est pull à partir de [axllent/mailpit](https://hub.docker.com/r/axllent/mailpit).

(Nous n'avons pas utilisé le registre de l'université d'Artois car sur les machines de l'IUT, ça ne marchait pas . . .)
