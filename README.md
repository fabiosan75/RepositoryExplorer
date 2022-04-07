# RepositoryExplorer para repositorios basados en PHP composer

- [Introducción](#introduccion)
- [Instalación](#instalacion)
- [Uso](#uso)
- [Logger](#logger)

RepositoryExplorer es una interface de lína de comandos que implementada PHP para explorar las dependencias de un repositorio
basado en composer y establecer la secuencia de commits de un pipe en un modelo de CI/CD, permite ver los paquetes 
por los que esta compuesto un proyecto y sus dependencias. 

Para un mejor entendimiento puede ver la documentación de referencia del [SCHEMA de composer](https://getcomposer.org/doc/04-schema.md).

## Instalación

### Libreria

```bash
git clone https://github.com/fabiosan75/RepositoryExplorer.git
```

### Configuración

```bash
git clone https://github.com/fabiosan75/RepositoryExplorer.git
```


## Uso

### Ver Ayuda

Ejecutando el comando con la opción -h, --help podrá ver la siguiente ayuda.
Ejecutando el comando con la opción -u, --usage podrá la información detallada del comando.


```
command [-h] [-u]

```
<pre>
USO: 	 src/CliApp.php [OPTION] [<args>]

<b>OPCIONES:</b>

         -u --usage                         Muestra la ayuda extendida e informacion del comando.
         -h --help                          Muestra la información de uso, command <options>.
         <b>-r --repository <path></b>               Ruta al repositorio
         <b>-s --show     <path></b>               Lista los archivos composer.json en el DIR del repositorio
         <b>-t --treeview <path></b>               Vista de Arbol del repositorio
         <b>-e --explore  <path></b>               Explora el repositorio muestra Vista de Arbol de cada SCHEMA
         -l --log                           Muestra contenido del log del comando.
         -v --version                       Ver version
</pre>         
         

### Displaying Help

### Logger


