# TID. Tarragona Identitat Digital
Paquet Laravel d'integració amb la plataforma Valid de l'AOC.
Permet securitzar rutes mitjançant un middleware.

[![Latest Stable Version](http://poser.pugx.org/ajtarragona/tid/v)](https://packagist.org/packages/ajtarragona/tid) 
[![Total Downloads](http://poser.pugx.org/ajtarragona/tid/downloads)](https://packagist.org/packages/ajtarragona/tid) 
[![Latest Unstable Version](http://poser.pugx.org/ajtarragona/tid/v/unstable)](https://packagist.org/packages/ajtarragona/tid) 
[![License](http://poser.pugx.org/ajtarragona/tid/license)](https://packagist.org/packages/ajtarragona/tid) 
[![PHP Version Require](http://poser.pugx.org/ajtarragona/tid/require/php)](https://packagist.org/packages/ajtarragona/tid)



## Instalació
```bash
composer require ajtarragona/tid:"@dev"
``` 

Amb la següent comanda publiquem els recursos per què el formulari d'accés a Vàlid es mostri correctament.
```bash
php artisan vendor:publish --tag=ajtarragona-tid-assets --force
```

## Configuració
Pots configurar el paquet a través de l'arxiu `.env` de l'aplicació. Aquests son els parámetres disponibles :

Paràmetre |  Descripció
--- | ---
VALID_CLIENT_ID | Id de client Vàlid 
VALID_CLIENT_SECRET | Secret del client Vàlid  


Alternativament, pots publicar l'arxiu de configuració del paquet amb la comanda:

```bash
php artisan vendor:publish --tag=ajtarragona-tid-config
```

Això copiarà l'arxiu `tid.php` a la carpeta `config`.



## Ús
Un cop configurat, el paquet està a punt per fer-se servir.
Bàsicament el que ens caldrà és securitzar les rutes a través del middleware `tid` que proporciona el paquet:

```php
Route::middleware(['tid'])->group( function () {
    Route::get('/test', 'TestTidController@page')->name('secure_page');
});
```


