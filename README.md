# CakePHP

[![Latest Stable Version](https://poser.pugx.org/cakephp/cakephp/v/stable.svg)](https://packagist.org/packages/cakephp/cakephp)
[![License](https://poser.pugx.org/cakephp/cakephp/license.svg)](https://packagist.org/packages/cakephp/cakephp)
[![Bake Status](https://secure.travis-ci.org/cakephp/cakephp.png?branch=master)](http://travis-ci.org/cakephp/cakephp)
[![Code consistency](http://squizlabs.github.io/PHP_CodeSniffer/analysis/cakephp/cakephp/grade.svg)](http://squizlabs.github.io/PHP_CodeSniffer/analysis/cakephp/cakephp/)

[![CakePHP](http://cakephp.org/img/cake-logo.png)](http://www.cakephp.org)

CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Active Record, Association Data Mapping, Front Controller and MVC.
Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.

## Especificaciones técnicas de infraestructura
* Sin importar el Sistema Operativo en el que te encuentres, deberás tener previamente instalado los siguientes servicios en tu maquina:

1. Apache
2. PHP 5.X
3. MySQL

NOTA: descarga aquí tu entorno de Desarrollo PHP - https://www.apachefriends.org/es/index.html

* Una vez instalados en tu ordenador, deberás asegurarte que tu máquina ya esta disponible en la WEB como una máquina local. 

## Instalación
1. El aplicativo Nurum presenta una estructura del Framework CakePHP, por lo que toda la aplicación como tal se encuentra disponible en la carpeta 'app'.
2. Para su instalación se deberá descargar por completo el código de este repositorio. Una vez descargado nos dirijimos al directorio donde tenemos acceso todos nuestros proyectos en la WEB y creamos un directorio con el nombre que decidas para este proyecto.
3. Una vez creado este directorio copiaras y pegaras todo el codigo decargado como se muestra en GitHub en la misma. 
4. Ya copiado el código en la carpeta, nos dirijimos a raiz->Schemma->abc.sql, donde encontraremos nuestro script de la base de datos. No dirijimos a la herramienta de tu elección para la administración de bases de datos MySql y creamos una base de datos con el nombre 'abc'. 
5. Creada la base de datos ejecutaremos el script 'abc.sql'.
6. Con la base de datos ya cragada, nos dirijimos a nuestro navegador para comprobar que ya tenemos acceso a nuestra aplicación.


## FB Connect
* Para el uso de la aplicación FB Connect deberás crear tu usuario en esta página https://developers.facebook.com/, una vez creada tu cuenta y hayas creado la aplicación en el proceso de esta url, deberás dirijirte a la vista app->View->Pages->home.ctp y modificar las siguientes lines por las que se te muestren en la url:

  - 'window.fbAsyncInit = function() {
      FB.init({
        appId      : 'tu ID',
        xfbml      : true,
        version    : 'v2.3'
      });
    };'

*Esto para que puedas hacer uso del registro y login de facebook.

## Contributing

[CONTRIBUTING.md](CONTRIBUTING.md) - Quick pointers for contributing to the CakePHP project

[CookBook "Contributing" Section (2.x)](http://book.cakephp.org/2.0/en/contributing.html) [(3.0)](http://book.cakephp.org/3.0/en/contributing.html) - Version-specific details about contributing to the project
