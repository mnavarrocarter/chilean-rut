Rut Chileno
===========

Esta librería implementa una clase Rut como un sencillo *value object* inmutable.

Además, posee dos *types* para `doctrine/dbal`.

## Instalación

Esta puede ser instalada mediante composer:

```
composer require mnavarrocarter/chilean-rut
```

## Uso

### Parseando un Rut

La clase Rut es capaz de parsear cualquier tipo de rut sin importar el formato usando
el método `Rut::parse()`. Confiadamente, puedes poner el valor directamente de un
formulario web y `parse` se encargará de sanitizar el string y ver si el RUT es válido.

> NOTA: Un Rut se considera válido cuando su dígito verificador es algorítmicamente válido
> para el número. Esta libreria no puede validar que el Rut existe realmente.
 
```php
<?php

use MNC\ChileanRut\Rut;

$rut = Rut::parse('23.546.565-4');
```

### Validando el RUT

> TLDR: Un objeto `Rut` siempre será valido.

Si tu RUT no es válido, el método `parse` lanzara una excepción de tipo
`MNC\Rut\IsInvalid`. Esto es para seguir buenos principios de *objects
calisthenics*: un objeto de valor siempre se crea en un estado válido, y se mantiene
válido a través de todo su ciclo de vida. No se permiten mutaciones que dejen el
objeto en un estado inválido.

Por esta razón el objeto `MNC\Rut\IsInvalid` es completamente inmutable. Esto quiere decir
que una vez creado no puedes cambiar su estado interno: solo puedes leer información.
Estos son los unicos métodos que puedes usar:

```php
<?php

use MNC\Rut;

$rut = Rut::parse('23.546.565-4');

$rut->number; // (int) 23546565
$rut->verifier; // (MNC\Rut\Verifier::Four) 4
```

### Formateando el Rut

Existen muchas formas distintas de formatear un RUT y esta librería soporta muchas
de ellas. El método format devuelve un objeto al cual puedes encadenar llamadas para
formatear el RUT y extraer su información de diversas maneras.

He aquí algunos ejemplos:

```php
<?php

use MNC\Rut;

$rut = Rut::parse('23.546.565-4');

echo $rut->toString();          // 235465654
echo $rut->toSimple();          // 23546565-4
echo $rut->toHuman();           // 23.546.565-4
echo $rut->last(4);             // 6565
echo $rut->last(4, pad: '*');   // ****6565
echo $rut->first(4);            // 2354
echo $rut->first(4, pad: '*');  // 2354****
```

## Integraciones con Librerías de Terceros

### Doctrine DBAL
Esta librería provee dos [*Custom Types*](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/cookbook/custom-mapping-types.html)
para Doctrine, con el objetivo de que puedas mapear tus objetos `Rut` fácilmente
a una base de datos relacional.

`MNC\Rut\Doctrine\RutType` mapea tu RUT a una columna VARCHAR.
El string se guarda con puntos y guion. Ex: `16.894.365-2`. Es una forma no tan
eficiente de guardar los RUTS (en términos de espacio), pero ayuda mucho cuando
se visualiza o exporta la base de datos a otras fuentes.

`MNC\Rut\Doctrine\NumericRutType` mapea tu RUT a una columna INTEGER.
El número se guarda sin dígito verificador y es recalculado cuando la columna
es transformada a un valor PHP. Esta forma de guardar ruts es muy eficiente (en
términos de espacio), pero cuesta comparar y leer los números si visualizas o
exportas los registros en la base de datos.

Por supuesto, puedes elegir el `Type` que más se ajuste a tus necesidades.

## FAQ

### ¿Por qué esta librería?
Esta librería nace de la necesidad de estandarizar una clase Rut común para todos
mis proyectos PHP.

Si bien es cierto, hay muchas librerías con implementaciones de Rut chilenos en PHP,
muchas de ellas tienen notorias deficiencias:

1. No están testeadas unitariamente.
2. No estan tipadas apropiadamente 
3. No tienen un buen diseño y sus apis tienen efectos secundarios.
4. Están acopladas a un framework (Laravel Rut y otras hierbas)
5. No proveen herramientas ni integraciones con librerías de terceros, como Doctrine.
