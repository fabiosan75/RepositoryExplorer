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
namespace GetTreeRepository\Util;

/**
 * CliMsg Implementa funciones para dar formato/color a textos para STD OUT
 *        [ANSI escape codes] definidos como constantes de la clase
 *                      
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class CliMsg
{
    /**
     * * Constantes para ANSI scape codes (colores texto STD OUT)
     */
    const BLOB_TXTCOD = ["\033[1m", "\033[0m"];
    const GREEN_TXTCOD = ["\033[1;32m", "\033[0m"];
    const RED_TXTCOD = ["\033[0;31m", "\033[0m"];
    const BLUE_TXTCOD = ["\033[1;34m", "\033[0m"];//array('\033[1;34m', '\033[0m');
    const PURPLE_TXTCOD = ["\033[0;35m", "\033[0m"];

    /**
     * * @var $formatText formatear mensajes de salida STDOUT
     */
    static $formatText = true;

    /**
     * Format some text for the console.
     *
     * @param string $text Cadena/texto a formatear si $formatText = true
     * @param string $wrap ANSI escape codes a aplicar ['before', 'after'].
     * 
     * @return string $text Retorna string de acuerdo con {@link Cli::$formatText}.
     */
    static function formatText(string $text, array $wrap): string 
    {
        if (self::$formatText) {
            return "{$wrap[0]}$text{$wrap[1]}";
        } else {
            return $text;
        }
    }

             
    /**
     * Method colorText
     *
     * @param string $text      Cadena/texto a aplicar formato con color
     * @param array  $colorCode [ANSI escape codes] <GREEN_TXTCOD RED_TXTCOD>
     *                          Definidos como constantes de la clase
     *
     * @return string Retona una cadena formateada con color Rojo para STD OUT.
     */
    public static function colorText(string $text,array $colorCode): string 
    {
        return self::formatText($text, $colorCode);
    }
 

}
