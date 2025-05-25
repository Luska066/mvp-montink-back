Requisitos

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
    
    sail up -d
    sail artisan migrate

adicione isso ao seu .env

    DB_CONNECTION=mysql
    DB_HOST=[nome do container docker que esta rodando o mysql, caso use o sail]
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password

Caso queira rodar com artisan (Não recomendado)
    
    php artisan migrate
    php artisan serve -p : 80





# mvp-montink-back
