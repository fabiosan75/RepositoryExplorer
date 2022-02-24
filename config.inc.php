<?php 

/**
 *  Descrición de paramentros y opciones de ejecución del commando 
 */

$README_COMMAND = '
 Usage: 
    getRepositoryTree.php [options] -- [args...]
 
 Options: 
    -h, --help Ver uso y lista de opciones
    -f <filePath>  Ruta al direcotorio que contiene el repositorio, por defecto ubicaciób alctual .
    -l --list Lista repositorios encontrados en el <filePath> especificado
    -t --tree Ver arbol dependencias  
     getRepositoryTree.php [options] [-B <begin_code>] -R <code> [-E <end_code>] [--] [args...]
     getRepositoryTree.php [options] [-B <begin_code>] -F <file> [-E <end_code>] [--] [args...]
     getRepositoryTree.php [options] -a
 
   
     -i 

';
