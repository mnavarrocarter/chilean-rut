Rut Chileno
===========

Esta librería implementa una clase Rut como un *value object* inmutable, incluyendo
una api de validación flexible y extendible. 

Además, posee un validador para `symfony/validator`, un *form type* para `symfony/form`
y un *type* para `doctrine/dbal`. 

Sólo es compatible con PHP 7.1 o superior.

## ¿Cómo nació y por qué esta librería?
Esta libería nace de la necesidad de estandarizar una clase Rut común para todos mis proyectos
PHP.
Si bien es cierto, hay muchas liberías con implementaciones de Rut chilenos en PHP,
muchas de ellas tienen notorias deficiencias:

1. No están testeadas unitariamente,
2. No separan bien responsabilidades, como la lógica de validación con la de instanciación.
3. No proveen validación extensible por medio de interfaces, limitando la validación
solo a ser algorítmica.
4. Están acopladas a un framework
5. No proveen herramientas ni integraciones con librerías de terceros.

## ¿Por qué PHP 7.1?
El fin del soporte de PHP 5.6 será a fines de 2018. PHP 7.1 es una de las últimas
versiones estables, y me beneficio mucho de su sistema de tipado estricto en esta libería.

