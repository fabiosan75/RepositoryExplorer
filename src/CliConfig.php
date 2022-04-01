<?php
/**
 * PHP version 7
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace GetTreeRepository;

require_once __DIR__.'/../vendor/autoload.php';

use GetTreeRepository\Util\CliException;
use GetTreeRepository\Util\CliMsg;

/**
 * Template Class Doc Comment
 *
 * CLIClass Class
 * CLIClass : Implementa los metodos necesarios para el uso de la linea de comandos
 *   crea los parametros de linea de comando, valida opciones, genera los mensajes
 *   por STDOUT según las opciones de entrada y parametros entregados al comando.
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class CliConfig
{


    const APP_NAME = 'PipeValidator';
    const VALID_OS = array('LINUX', 'DARWI'); // max long char(5)

    private $_version = '1.0.0';  

    private $_versiondate = '17-03-2022';
    private $_appname = 'Pipe Composer Repository Explorer';

    private static $_logo = "
    ___                  _ _  __  __        ______ _            
    / _ \                | (_)/ _|/ _|       | ___ (_)           
   / /_\ \_ __ ___  _ __ | |_| |_| |_ _   _  | |_/ /_ _ __   ___ 
   |  _  | '_ ` _ \| '_ \| | |  _|  _| | | | |  __/| | '_ \ / _ \
   | | | | | | | | | |_) | | | | | | | |_| | | |   | | |_) |  __/
   \_| |_/_| |_| |_| .__/|_|_|_| |_|  \__, | \_|   |_| .__/ \___|
                   | |                 __/ |         | |         
                   |_|                |___/          |_|         
   ";

    static $MAN_FOOTER;
    static $MAN_HEADER;

    static $MAN_DESC = <<<MAN

NAME
       CliApp.php - Valida la estructura de un repositorio basado en composer.

SYNOPSIS
       CliApp.php [-h]
       CliApp.php [-v]
       CliApp.php [-l src]
       CliApp [-e src]

DESCRIPTION
       CliApp es una herramienta para explorar las dependencias y establecer 
       la secuencia de commits de un pipe en un modelo de CI/CD, permite ver los 
       paquetes por los que esta compuesto un proyecto. 

       Usabilidad : 
        La opcion [-e src/Path] la aplicacion mostrara el SCHEMA de los paquetes 
        encontrados en la ruta.
      
          /pathname/composer.json
            |_name : fabiosan75/proyecto1
            |_description : Estructura para  de proyecto 1 bajo modelo CI-CD
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
                 |_url : https://github.com/fabiosan75/libreria2
              |_3

        La opcion [-s src/Path] la aplicacion mostrara los repositorios/paquetes 
        encontrados.

MAN;
       static $MAN_DIAGNOSTICS = <<<MAN

DIAGNOSTICS
       Se generan mensajes informativos al ejecutar el comando usando parametros
       equivocados 
        (ej. CLI Error/Opcion Desconocida)

AUTHOR
       Creado por fabiosan75, para la validacion rapida de un repositorio
       de composer y sus dependencias.

MAN;

    public static $options = array();

    public static $optionDefs = array(
        'u' => array('Muestra la ayuda extendida e informacion del comando.', 
                      'long' => 'usage'),
        'h' => array('Muestra la información de uso, command <options>.', 
                      'long' => 'help'),
        'r' => array('Ruta al repositorio', 
                      'long' => 'repository'),
        's' => array('Lista los archivos composer.json en el DIR del repositorio', 
                      'long' => 'show'),
        't' => array('Vista de Arbol del repositorio', 
                      'long' => 'treeview'),
        'e' => array('Explora el repositorio muestra una Vista de Arbol de cada SCHEMA', 
                      'long' => 'explore'),
        'l' => array('Muestra contenido del log del comando.', 
                      'long' => 'log'),
        'v' => array('Ver version', 
                      'long' => 'version')   
    );
    

    
    /**
     * Method configureCli
     *
     * @return void
     */
    public function configureCli(): void
    {
        self::$MAN_HEADER = PHP_EOL.
                            "$this->_appname                ".
                            "Manual General del Comando        (1)";

        self::$MAN_FOOTER = PHP_EOL."Version : $this->_version                     ".
                            "$this->_versiondate                 $this->appname (1)";

        $shortOptionsList = array_keys(self::$optionDefs);
        self::$options = $this->parseOptions($_SERVER['argv'], $shortOptionsList);
        //  self::$options = $this->parseOptionsOK();

        //  $parser = new Parser();
        //  self::$options = $parser->parse($_SERVER['argv']);

    }

    /**
     * Method parseOptions Valida los argumentos de la linea de comando y 
     *                     retorna un array con las opciones.
     *
     * @param array $args    array con los argumentos de la linea de comandos.
     * @param array $allowed Array con las opciones disponibles.
     *
     * @return array retorna un array con las opciones y parametros.
     *
     * @example
     *   -h -s -l
     *    array()
     */
  
    static public function parseOptions($args, $allowed = array()): array
    {
 
        $options = array();
        $count = count($args);
 
        // retrive arguments and populate $options array
        for ($i = 1; $i < $count; $i++) {
            // retrieve arguments in form of --abc=foo
            if (preg_match('/^--([-A-Z0-9]+)=(.+)$/i', $args[$i], $matches)) {
            
                try { 
                    if (empty($allowed) || in_array($matches[1], $allowed)) {
                        $options[$matches[1]] = $matches[2];
                    } else {
                        throw new CliException('Opcion Desconocida ' . $matches[1]);
                    }
                } catch (CliException $e){
                    $e->cliError();
                }

            } else if (substr($args[$i], 0, 2) == '--') { // retrieve --abc arguments
                
                $tmp = substr($args[$i], 2);

                try{
                    if (empty($allowed) || in_array($tmp, $allowed)) {
                        $options[$tmp] = true;
                    } else {
                        throw new CliException('Opcion Desconocida ' . $tmp);
                    }
                } catch (CliException $e) {
                    $e->cliError();
                }

            } else {  // retrieve -abc foo, -abc, -a foo and -a arguments
                try {
                    if ($args[$i][0] == '-' && strlen($args[$i]) > 1) {
              
                        // set all arguments to true except for last in sequence
                        for ($j = 1; $j < strlen($args[$i]) - 1; $j++) {

                            try {
                                if (empty($allowed) || 
                                    in_array($args[$i][$j], $allowed)
                                ) {
                                    $options[$args[$i][$j]] = true;
                                } else {
                                    throw new CliException(
                                        'Opcion Desconocida ' . $args[$i][$j]
                                    );
                                }
                            } catch (CliException $e){
                                  $e->cliError();
                            }
                        }
      
                        $tmp = substr($args[$i], -1, 1);

                        try {
                            if (empty($allowed) || in_array($tmp, $allowed)) {

                                if ($i + 1 < $count && $args[$i + 1][0] != '-') {
                                    $options[$tmp] = $args[$i + 1];
                                    $i++;
                                } else {
                                    $options[$tmp] = true;
                                }
                            } else {
                                throw new CliException('Opcion Desconocida ' . $tmp);
                            }
                        } catch (CliException $e){
                            $e->cliError();
                        }
                    } else {
                        throw new CliException('Formato Invalido ' . $args[$i]);
                    }
                } catch (CliException $e){
                      $e->cliError();               
                }
            }
        }
    
        return $options;
    }

    /**
     * Method help Muestra la ayuda extendida e informacion del comando, las 
     *        opciones del comando CLI basado en $optionDefs
     *
     * @return string
     */
    public static function help(): string
    {
        $strline = '';

        $strline = CliMsg::colorText(
            self::$_logo, 
            CliMsg::PURPLE_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::$MAN_HEADER.PHP_EOL, 
            CliMsg::BLUE_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::$MAN_DESC.PHP_EOL, 
            CliMsg::BLUE_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::usage(), 
            CliMsg::GREEN_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::$MAN_DIAGNOSTICS.PHP_EOL, 
            CliMsg::BLUE_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::$MAN_FOOTER.PHP_EOL, 
            CliMsg::BLUE_TXTCOD
        );

        return $strline;

    }
    
    /**
     * Method usage Devuelve el texto de uso en linea de comando y la 
     *  descripcion de sus opciones
     *
     * @return string
     */
    public static function usage(): string
    {

        $strline = '';

        $cmdname = isset($GLOBALS['argv'][0]) ? $GLOBALS['argv'][0] : self::APP_NAME;

        $strline .= "\n"
              . "USAGE:"
              . "\t $cmdname [OPTION]...\n"
              . "\n";

        foreach (self::$optionDefs as $name => $def) {

            $def += array('default' => '', 'short' => false);
            $strline .= sprintf(
                " %10s %-20s %s\n",
                $def['long'] ? ('-' . $name) : '',
                "--".$def['long'],
                $def[0]
            );

        }
        return $strline;

    }

    /**
     * Method checkOS Valida el sistema operativo en el que se ejecuta CLI
     *
     * @return bool
     */
    static function checkOS(): bool
    {
        return in_array(strtoupper(substr(PHP_OS, 0, 5)), self::VALID_OS);

    }

}
