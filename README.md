<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Moto Black Painel Administrativo/Api

Este repositório contém o site para moderador dos aplicativos do moto-black assim como endpoints de consumo para os mesmos.


<a href="https://github.com/AlbertoJr789/app-motoblack-cliente">Link Aplicativo Passageiro</a>

<a href="https://github.com/AlbertoJr789/app-motoblack-mototaxista">Link Aplicativo Mototaxista</a>


## Softwares necessários

PHP: Versão 8.1 a 8.3

Composer: Versão 2.8.6

Node: Versão 23.10

Sugiro utilizar o <a href="https://herd.laravel.com">Laravel Herd</a> para instalar todos os softwares convenientemente.

## Configurações

Instale as dependências do composer:

    composer install

Instale as dependências frontend:

    npm install

Após instalar as dependências frontend, execute o vite para gerar o bundle contendo a compilação das dependências frontend.

    npm run build

Copie e renomeie o .env.example para .env e atente-se às seguintes variáveis lá dentro (além das que se referem ao banco de dados):

    APP_URL=http://${IPV4}:8000 (a porta é importante para os links simbólicos das fotos de usuário)

    FIREBASE_URL=https://exemplo-default-rtdb.firebaseio.com
    HERE_API_KEY=djjawdoajw92941924090asdj

Limpe qualquer arquivo de cache antigo que possa estar no projeto:

    php artisan config:clear

Habilite o link simbólico do storage privado com a pasta pública para que as fotos de perfil sejam visíveis:

    php artisan storage:link

Gere uma nova chave para o projeto caso necessário

    php artisan key:generate

Migre o banco de dados

    php artisan migrate

Você pode rodar as factories para que registros fictícios sejam criados também:

    php artisan db:seed

Isso inclusive já gera um usuário para acessar a página:

    username: admin
    senha: 123123123

## Executando a aplicação

Para expor a aplicação aos aplicativos utilize o artisan:

    php artisan serve --host=0.0.0.0

Com a flag --host, será possível consumir os endpoints de API pelos aplicativos. Lá, utiliza-se a url base como o ipv4 da máquina na rede LAN. O celular deve estar conectado no mesmo wi-fi que o computador servindo este projeto. 