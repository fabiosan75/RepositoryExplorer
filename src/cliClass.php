<?php

namespace repositoryValidator;
/**
 * Template File Doc Comment
 *
 * PHP version 7
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 *
 */

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
 *
 */


class CLIClass
{

/**
 * * @var bool formatear mensajes de salida STDOUT
 *
 */
    protected $formatText;

    const VALID_OS = array('UNIX', 'LINUX', 'DARWIN');

    public static $options = array();

    private static $optionDefs = array(
        'help' => array('Show usage information', 'default' => false, 'short' => 'h'),
        'config' => array('Alternate path to config file', 'short' => 'c'),
        'appname' => array('Alternate appname', 'short' => 'a'),
        'daemon' => array('Run as a background daemon', 'default' => false, 'short' => 'd'),
        'pidfile' => array('PID file location', 'short' => 'p'),
        'environment' => array('Set RESQUE_ENV', 'short' => 'E'),
        'term-graceful-wait' => array('On TERM signal, wait for workers to shut down gracefully'),
        'term-graceful' => array('On TERM signal, shut down workers gracefully'),
        'term_immediate' => array('On TERM signal, shut down workers immediately (default)'),
    );
    
    /**
     * Method __construct
     *
     * @return void
     */
    function __construct()
    {
        $this->configureCli();
        $this->formatText = $this->checkOS();
    }

    /**
     * Configure the CLI for usage.
     */
    function configureCli(): void
    {
        $this->options = $this->parseOptions();
    }

    public function parseOptions(): array
    {
        $shortopts = '';
        $longopts = array();
        $defaults = array();

        foreach (self::$optionDefs as $name => $def) {
            $def += array('default' => '', 'short' => false);

            $defaults[$name] = $def['default'];
            $postfix = is_bool($defaults[$name]) ? '' : ':';

            $longopts[] = $name.$postfix;
            if ($def['short']) {
                $shortmap[$def['short']] = $name;
                $shortopts .= $def['short'].$postfix;
            }
        }

         
    }

    function usage()
    {
        $cmdname = isset($GLOBALS['argv'][0]) ? $GLOBALS['argv'][0] : 'resque-pool';
        echo "\n"
            . "Usage:"
            . "\t$cmdname [OPTION]...\n"
            . "\n";
        foreach (self::$optionDefs as $name => $def) {
            $def += array('default' => '', 'short' => false);
            printf(" %2s %-20s %s\n",
                $def['short'] ? ('-' . $def['short']) : '',
                "--$name",
                $def[0]
            );
        }
        echo "\n\n";
    }

    /**
     * Method checkOS
     *
     * @return bool
     */
    function checkOS(): bool
    {

        return in_array(strtoupper(substr(PHP_OS)), self::VALID_OS);

    }

}
