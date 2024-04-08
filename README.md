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
