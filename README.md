Rut Chileno
===========

Esta librería implementa una clase Rut como un sencillo *value object* inmutable.

Además, posee dos *types* para `doctrine/dbal`.

## Instalación

Esta libería funciona con composer:

```
composer require mnavarrocarter/chilean-rut
```

## Uso

### Parseando un Rut

La clase Rut es capaz de parsear cualquier tipo de rut sin importar el formato usando
el método `Rut::parse()`. Confiadamente puedes poner el valor directamente de un
formulario web y `parse` se encargara de sanitizar el string y ver si el RUT es valido.
 
```php
<?php

use MNC\ChileanRut\Rut;

$rut = Rut::parse('23.546.565-4');
```

### Validando el Rut

> TLDR: Un objeto `Rut` siempre será valido.

Si tu RUT no es valido, el método `parse` lanzara una excepción de tipo
`MNC\ChileanRut\InvalidRut`. Esto es para seguir buenos principios de *objects
calisthenics*: un objeto de valor siempre se crea en un estado valido, y se mantiene
valido a través de todo su ciclo de vida. No se permiten mutaciones que dejen el
objeto en un estado invalido.

Por esta razón el objecto `$rut` es completamente inmutable. Esto quiere decir
que una vez creado no puedes cambiar su estado interno: solo puedes leer información.
Estos son los unicos métodos que puedes usar:

```php
<?php

use MNC\ChileanRut\Rut;

$rut = Rut::parse('23.546.565-4');

$rut->getNumber(); // (int) 23546565
$rut->getVerifier(); // (string) 4
```

### Formateando el Rut

Existen muchas formas distintas de formatear un rut y esta librería soporta muchas
de ellas. El método format devuelve un objeto al cual puedes encadenar llamadas para
formatear el rut y luego castearlo a un string. La interfaz es encadenable para que
puedas combinar las opciones de formato como quieras.

```php
<?php

use MNC\ChileanRut\Rut;

$rut = Rut::parse('23.546.565-4');

echo $rut->format()->hyphened();                            // 23546565-4
echo $rut->format()->dotted()->hyphened();                  // 23.546.565-2
echo $rut->format()->dotted()->hyphened()->obfuscated();    // **.***.565-2
echo $rut->format()->obfuscated()->hyphened();              // *****565-2
echo $rut->format()->obfuscated();                          // *****5652
```

## Integraciones con Librerías de Terceros

### Doctrine DBAL
Esta librería provee dos [*Custom Types*](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/cookbook/custom-mapping-types.html)
para Doctrine, con el objetivo de que puedas mapear tus objetos `Rut` fácilmente
a una base de datos relacional.

El `MNC\ChileanRut\Doctrine\RutType` mapeara tu RUT a una columna VARCHAR.
El string se guarda con puntos y guion. Ex: `16.894.365-2`. Es una forma no tan
eficiente de guardar los RUTS (en términos de espacio), pero ayuda mucho cuando
se visualiza o exporta la base de datos a otras fuentes.

El `MNC\ChileanRut\Doctrine\NumericRutType` mapeara tu RUT a una columna INTEGER.
El numero se guarda sin digito verificador y es recalculado cuando la columna
es transformada a un valor PHP. Esta forma de guardar ruts es muy eficiente (en
términos de espacio), pero cuesta comparar y leer los números si visualizas o
exportas los registros en la base de datos.

Por supuesto, puedes elegir el `Type` que más se ajuste a tus necesidades.

## FAQ

### ¿Cómo nació y por qué esta librería?
Esta librería nace de la necesidad de estandarizar una clase Rut común para todos
mis proyectos PHP.

Si bien es cierto, hay muchas librerías con implementaciones de Rut chilenos en PHP,
muchas de ellas tienen notorias deficiencias:

1. No están testeadas unitariamente,
2. No tienen un buen diseño y sus apis tienen efectos secundarios.
3. Están acopladas a un framework (Laravel Rut y otras hierbas)
4. No proveen herramientas ni integraciones con librerías de terceros.

### ¿Por qué PHP 7.4?
PHP 7.3 ya no tiene mucho tiempo de soporte y 8.0 esta ad portas de ser lanzado. Hay que
empujar el ecosistema hacia adelante.
