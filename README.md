
composer create-project laravel/laravel .
composer require laravel/ui
php artisan ui bootstrap --auth
php artisan migrate
npm install && npm run dev
composer require --dev laravel-lang/common

.env
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES

php artisan lang:update

composer require livewire/livewire
php artisan livewire:publish --config

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')

    @livewireScripts
    @stack('scripts')



php artisan install:api --passport
php artisan passport:keys
php artisan vendor:publish --tag=passport-config

Para Crear las credenciales de Passport
php artisan passport:client --personal


php artisan make:livewire Bancos.CrearBanco 
