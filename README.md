# Colppy test

## Demo
[Click aqui para el live demo](http://colppy.herokuapp.com)

> admin@colppy.com / colppy

## Instalación
```
$ composer install && npm install
```
Le pedira una opcion a seleccionar , digite el numero 1, luego de esto
Abrir ```.env``` e ingrese la configuración necesaria para la DB.

```
$ php artisan migrate --seed

```
Este comando , creara y popular registros necesarios en la base de datos, para ejecutar la aplicación.

## Work Flow

**General Workflow**

```
$ php artisan serve --host=0
```
Abrir una nueva terminal
```
$ gulp && gulp watch

```

**Test unitarios**
Se encuentran en la carpeta ```/tests```, para ejecutarlos.
```
$ vendor/phpunit/phpunit/phpunit

```
ó si ya tienen instalado phpunit
```
$ phpunit

```

> Default Username/Password: admin@colppy.com / colppy



## Las respuestas del test estan incluidas en la aplicación en el menu de respuestas del test
De antemano saludos y muchas gracias.
