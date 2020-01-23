# Backend
Laravel APIs de Produtos, Feito tudo na branch master

#   Copiar projeto
git clone https://github.com/nando09/backend.git

#   Inicio
composer install

#   Declarar arquivo .env
php artisan key:generate

#   Configurar .env
DB_DATABASE =   "nome da sua base"
DB_USERNAME =   "nome do banco"
DB_PASSWORD =   "senha do banco"

QUEUE_CONNECTION    =   database

#   Comando para criar tabelas
php artisan migrate

#   Comando para criar um serve
php artisan serve

#   Comando para observar o Queue
php artisan queue:work

#   Urls
[Post]      =>   http://localhost:8000/api/products
    form-data   =>  {
        file
    }
    Somente em arquivo    

[GetAll]    =>   http://localhost:8000/api/products

[Get]       =>   http://localhost:8000/api/products/{id}

[Delete]    =>   http://localhost:8000/api/products/{id}

[Put]       =>   http://localhost:8000/api/products/{id}
    x-www-form-urlencode    =>  {
        im: number
        name: string
        free_shipping: 0 ou 1
        description: string
        price: decimal(20, 2)
    }
