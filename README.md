Requisitos

## Deploy
    
    FRONT : http://54.207.91.242:9000/
    API : http://54.207.91.242/

use o php 8.2

    composer install

Configure o Email :

    MAIL_MAILER=
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=STARTTLS
    MAIL_FROM_ADDRESS=montink@mailtrap.com
    MAIL_FROM_NAME="${APP_NAME}"

Caso rode com sail (recomendado)
    
    vendor/bin/sail up -d
    ou 
    sail up -d

adicione isso ao seu .env

    DB_CONNECTION=mysql
    DB_HOST=[nome do container docker que esta rodando o mysql, caso use o sail]
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password

    DEPOIS EXECUTE
    
    vendor/bin/sail artisan migrate
    ou
    sail artisan migrate

Caso queira rodar com artisan (Não recomendado)
    
    php artisan migrate
    php artisan serve -p : 80

# mvp-montink-back
