<?php

/**
 * PHP version 7
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace RepositoryExplorer;

use RepositoryExplorer\Util\CliException;
use RepositoryExplorer\Util\CliMsg;

/**
 * CLIClass Class Implementa los metodos necesarios para el uso de CLI
 *   crea los parametros de linea de comando, valida opciones, genera los mensajes
 *   por STDOUT según las opciones de entrada y parametros entregados al comando.
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class CliConfig
{
    private const APP_NAME = 'PipeValidator';
    private const VALID_OS = array('LINUX', 'DARWI'); // max long char(5)

    private string $version = '1.0.0';

    private string $versiondate = '17-03-2022';
    private string $appname = 'Pipe Composer Repository Explorer';

    private static string $logo = "
    ___                  _ _  __  __        ______ _            
    / _ \                | (_)/ _|/ _|       | ___ (_)           
   / /_\ \_ __ ___  _ __ | |_| |_| |_ _   _  | |_/ /_ _ __   ___ 
   |  _  | '_ ` _ \| '_ \| | |  _|  _| | | | |  __/| | '_ \ / _ \
   | | | | | | | | | |_) | | | | | | | |_| | | |   | | |_) |  __/
   \_| |_/_| |_| |_| .__/|_|_|_| |_|  \__, | \_|   |_| .__/ \___|
                   | |                 __/ |         | |         
                   |_|                |___/          |_|         
   ";

    private static string $MAN_FOOTER;
    private static string $MAN_HEADER;

    private static string $MAN_DESC = <<<MAN

NAME
       CliApp.php - Valida la estructura de un repositorio basado en composer.

SYNOPSIS
       CliApp.php [-h]
       CliApp.php [-v]
       CliApp.php [-l src]
       CliApp [-e src]

DESCRIPCION
       CliApp es una herramienta para explorar las dependencias de un repositorio
       basado en composer y establecer la secuencia de commits de un pipe en un
       modelo de CI/CD, permite ver los paquetes por los que esta compuesto 
       un proyecto. 

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

    private static string $MAN_DIAGNOSTICS = <<<MAN

DIAGNOSTICO
       Se generan mensajes informativos al ejecutar el comando usando parametros
       equivocados 
        (ej. CLI Error/Opcion Desconocida)

AUTHOR
       Creado por fabiosan75, para la validacion rapida de un repositorio
       de composer y sus dependencias.

MAN;

    /**
     * @var array<int|string, string>
     */
    public static array $options = [];

    /**
     * @var array<string, array<string, string>>
     */
    public static array $optionDefs = array(
        'u' => array('desc' => 'Muestra la ayuda extendida e informacion del comando.',
                     'long' => 'usage',
                     'args' => ''),
        'h' => array('desc' => 'Muestra la información de uso, command <options>.',
                     'long' => 'help',
                     'args' => ''),
        'p' => array('desc' => 'Muestra la información de uso, command <options>.',
                     'long' => 'pipe',
                     'args' => '<path>'),
        'r' => array('desc' => 'Ruta al repositorio',
                     'long' => 'repository',
                     'args' => '<path>'),
        's' => array('desc' => 'Lista los archivos composer.json en el DIR del repositorio',
                     'long' => 'show',
                     'args' => '<path>'),
        't' => array('desc' => 'Vista de Arbol dependencias repositorio',
                     'long' => 'treeview',
                     'args' => '<path>'),
        'e' => array('desc' => 'Explora el repositorio muestra Vista de Arbol de cada SCHEMA',
                     'long' => 'explore',
                     'args' => '<path>'),
        'l' => array('desc' => 'Muestra contenido del log del comando.',
                     'long' => 'log',
                     'args' => ''),
        'v' => array('desc' => 'Ver version',
                     'long' => 'version',
                     'args' => '')
    );

    /**
     * Method configureCli
     *
     * @return void
     */
    public function configureCli(): void
    {
        self::$MAN_HEADER = PHP_EOL .
                            "$this->appname                " .
                            "Manual General del Comando        (1)";

        self::$MAN_FOOTER = PHP_EOL . "Version : $this->version                     " .
                            "$this->versiondate                $this->appname (1)";

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
     * @param array<int, mixed>  $args    Array con argumentos de linea de comandos.
     * @param array<int, string> $allowed Array con las opciones disponibles.
     *
     * @return array<int|string, string> $options Array con opciones y parametros.
     *
     * @example
     *   -h -s -l
     *    array()
     */
    public static function parseOptions(array $args, array $allowed): array
    {

        $options = [];
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
                } catch (CliException $e) {
                    $e->cliError();
                }
            } elseif (substr($args[$i], 0, 2) == '--') { // retrieve --abc arguments
                $tmp = substr($args[$i], 2);

                try {
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
                                if (
                                    empty($allowed)
                                    || in_array($args[$i][$j], $allowed)
                                ) {
                                    $options[$args[$i][$j]] = true;
                                } else {
                                    throw new CliException(
                                        'Opcion Desconocida ' . $args[$i][$j]
                                    );
                                }
                            } catch (CliException $e) {
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
                        } catch (CliException $e) {
                            $e->cliError();
                        }
                    } else {
                        throw new CliException('Formato Invalido ' . $args[$i]);
                    }
                } catch (CliException $e) {
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
            self::$logo,
            CliMsg::PURPLE_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::$MAN_HEADER . PHP_EOL,
            CliMsg::BLUE_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::$MAN_DESC . PHP_EOL,
            CliMsg::BLUE_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::usage(),
            CliMsg::GREEN_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::$MAN_DIAGNOSTICS . PHP_EOL,
            CliMsg::BLUE_TXTCOD
        );

        $strline .= CliMsg::colorText(
            self::$MAN_FOOTER . PHP_EOL,
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
              . "USO: \t $cmdname [OPTION] [<args>]\n\n"
              . "OPCIONES:\n"
              . "\n";

        foreach (self::$optionDefs as $name => $def) {
            $def += array('default' => '', 'short' => false);
            $strline .= sprintf(
                " %10s %-10s %-20s %s\n",
                $def['long'] ? ('-' . $name) : '',
                "--" . $def['long'],
                $def['args'],
                $def['desc']
            );
        }
        return $strline;
    }

    /**
     * getFooter
     *
     * @return string
     */
    public function getFooter(): string
    {
        return self::$MAN_FOOTER;
    }

    /**
     * Method checkOS Valida el sistema operativo en el que se ejecuta CLI
     *
     * @return bool
     */
    public static function checkOS(): bool
    {
        return in_array(strtoupper(substr(PHP_OS, 0, 5)), self::VALID_OS);
    }
}
