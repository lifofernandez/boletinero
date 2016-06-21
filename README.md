# Boletinero
script PHP/twig para hacer los boletines de ATAM

## Instalar dependencias

```bash
$ composer install
```

Si se instala TWIG "a mano" (sin Composer) incluir "Autoloader"...

```php
require_once '/path/to/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
```

## CSS Inline 

Insatalar [Premailer Ruby Gem](https://github.com/premailer/premailer/) 

```bash
$ sudo gem install premailer
```

Indicarle a PHP en donde esta el ejecutable de PHP CLI wrapper for Premailer

```php
// Path to Premailer Binary
    $premailer = new Command('~/.gem/ruby/2.3.0/gems/premailer-1.8.6/bin/premailer');
```

Agregar parametro 'inline' o 'i' para pasar salida por Premailer
 
```bash
$ php build.php inline
```
