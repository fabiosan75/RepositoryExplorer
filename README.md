
# RepositoryExplorer para repositorios basados en PHP composer

- [Introducción](#introduccion)
- [Instalación](#instalacion)
- [Ejecución](#ejecucion)
- [Log](#logger)

## Introduccion

RepositoryExplorer es una interface de lína de comandos que implementada PHP para explorar las dependencias de un repositorio
basado en composer y establecer la secuencia de commits de un pipe en un modelo de CI/CD, permite ver los paquetes 
por los que esta compuesto un proyecto y sus dependencias. 

Para un mejor entendimiento puede ver la documentación de referencia del [SCHEMA de composer](https://getcomposer.org/doc/04-schema.md).

## Instalacion

### Libreria

Puede obtener el proyecto clonando el repositorio directamente.
```bash
git clone https://github.com/fabiosan75/RepositoryExplorer.git
```

### Configuracion

```bash
git clone https://github.com/fabiosan75/RepositoryExplorer.git
```

## Ejecucion

El script puede ejecutarse pasándolo como argumento al interprete de php

`$ > php src/CliApp.php [opcion] <argumento>`

Tambien puede ejecutarse directamente como aplicación :

`$ > ./src/CliApp.php [opcion] <argumento>`

El script contiene en la primer línea un [shebang](https://en.wikipedia.org/wiki/Shebang_(Unix)) para sistemas operativos basados en Linux #!/usr/bin/php  En el caso de ejecutarlos directamente no olvidar hacer el script ejecutable : 

`$ > chmod +x src/CliApp.php`

Cuando las lineas generadas por el comando sean mayores al buffer de su consola o terminal, 

`$ > php src/CliApp.php [opcion] <argumento> > packageResult.txt` 

### Ver Ayuda

Ejecutando el comando con la opción -h, --help podrá ver la siguiente ayuda.
Ejecutando el comando con la opción -u, --usage podrá la información detallada del comando.

```
command [-h] [-u]
```

<pre>
<b>USO:	 src/CliApp.php </b>[OPTION] <_args>

<b>OPCIONES:</b>

      -u --usage              Muestra la ayuda extendida e informacion del comando.
      -h --help               Muestra la información de uso, command <options>.
      <b>-r --repository <_path></b> Ruta al repositorio
      <b>-s --show       <_path></b> Lista los archivos composer.json en el DIR del repositorio
      <b>-t --treeview <_path></b>   Vista de Arbol del repositorio
      <b>-e --explore  <_path></b>   Explora el repositorio muestra Vista de Arbol de cada SCHEMA 
      -l --log                Muestra contenido del log del comando.
      -v --version            Ver version de aplicación
</pre>         
         

### Ejemplo

> Listar los archivos composer.json en el DIR del repositorio

`php src/CliApp.php -s ../   `

Explora el directorio especificado en <b>../</b> en busqueda de los archivos composer.json de repositorio.
```
<b>Lista los archivos composer.json en el DIR del repositorio src/Path : ../</b>
                 libreria1 =>  ..//libreria1/composer.json
                 Proyecto1 =>  ..//Proyecto1/composer.json
                 libreria2 =>  ..//libreria2/composer.json
                 libreria4 =>  ..//libreria4/composer.json
                 Proyecto2 =>  ..//Proyecto2/composer.json
```
> Ver SCHEMAs en el repositorio

`php src/CliApp.php -e ../   `

Explora el directorio especificado en <b>../</b> y genera un treeView de los schemas encontrados
```
<b>Explora el repositorio muestra Vista de Arbol de cada SCHEMA src : ../</b>
<b>name : fabiosan75/libreria2</b>
    |_name : fabiosan75/libreria2
    |_description : Libreria 2 Prueba Dependencia Proyectos Librerias CI/CD
    |_type : library
    |_license : proprietary
    |_repositories
       |_0
          |_type : vcs
          |_url : https://github.com/fabiosan75/libreria4
       |_1
          |_type : vcs
          |_url : https://github.com/fabiosan75/libreria5
    |_autoload
       |_psr-4
          |_Fabiosan75\Libreria2\ : src/
    |_authors
       |_0
          |_name : fabiosan75
          |_email : fabiosan75@gmail.com
    |_minimum-stability : stable
    |_require
       |_php : >=7.4
       |_fabiosan75/libreria4 : 1.0.0
       |_fabiosan75/libreria5 : 1.0.0
  
<b>name : fabiosan75/proyecto2</b>
    |_name : fabiosan75/proyecto2
    |_description : Estructura para organización de proyecto 2 bajo modelo CI-CD
    |_type : project
    |_license : proprietary
    |_repositories
       |_0
          |_packagist.org :
       |_1
          |_type : vcs
          |_url : https://github.com/fabiosan75/libreria1
       |_2
          |_type : vcs
          |_url : https://github.com/fabiosan75/libreria4
    |_autoload
       |_psr-4
          |_Fabiosan75\Proyecto2\ : src/
    |_authors
       |_0
          |_name : fabiosan75
          |_email : fabiosan75@gmail.com
    |_require
       |_php : >=7.4
       |_fabiosan75/libreria1 : 1.0.0
       |_fabiosan75/libreria4 : 1.0.0
```
> Arbol de dependencias de repositorio

`php src/CliApp.php -t ../   `

Explora el directorio especificado en <b>../</b> generando de los SCHEMAs encontrados la dependencias del repositorio por proyecto **type: "project"**
```
Lista los archivos composer.json en el DIR del repositorio src/Path : ../
**Vista de Arbol repositorio src : ../**
 Dependencias :
    |_fabiosan75/proyecto1
       |_fabiosan75/libreria1 : fabiosan75/libreria1
       |_fabiosan75/libreria2
          |_fabiosan75/libreria4 : fabiosan75/libreria4
          |_fabiosan75/libreria5 : fabiosan75/libreria5
    |_fabiosan75/proyecto2
       |_fabiosan75/libreria1 : fabiosan75/libreria1
       |_fabiosan75/libreria4 : fabiosan75/libreria4
```

### Log

Se genera un log de errores sin un formato especifico con el detalle de los errores presentados y capturados durante la ejecución del CLI. El archivo log.txt es creado en el directorio de la aplicación.

### Autor

Esta aplicación fue creada por fabiosan75 para Ampliffy como plan de evaluación.


