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
 * ArrayUtil Funciones para manipulación de arrays
 * 
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class ArrayUtil
{
    /**
     *  Method treeView  Genera una vista de arbol de un array asociativo
     *                   multidimensional, retorna string con la
     *                   representación en forma de arbol.
     *                        |padre : valor
     *                              |_nodo : valor
     *                                  |_nodo : valor
     *
     * @param array $data  Array asociativo 
     * @param int   $level Nivel inicial default 1
     *
     * @return string
     */
    public static function treeView(array $data,int $level): string 
    {
        
        $spaces = '';                                        
        for ($i = 0; $i <= ($level*3); $i++) {
            $spaces = $spaces.' ';
        }
        $branch = '';

        foreach ($data as $key => $value) {

            if (!(is_array($value))) {                       
                $indent = '';
                
                for ($i = 0; $i <= (strlen($key)+3); $i++) {   // 
                    $indent = $indent.' ';
                }

                $value = str_replace("\n", "\n ".$spaces.$indent, $value);
                $branch = $branch.$spaces."|_".$key." : ".$value.PHP_EOL;

            } else {                            
                // Agregar titulo a la rama para el siguiente nivel
                $next = self::treeView($value, ($level+1));
                $branch = $branch.$spaces."|_".$key.PHP_EOL.$next;
            }
        }
        return $branch;

    }
     
    /**
     * Method arrayReplace Busca el string $find por llave en un array 
     *                     multidimensional y lo reemplaza por $replace
     *                     Retorna el array con los nuevos valores
     *
     * @param array  $array   Array origen de datos
     * @param string $find    Llave a buscar
     * @param $replace Valor a reemplazar
     *
     * @return array
     */
    public static function arrayReplace(
        array $array,
        string $find, 
        $replace
    ):array {
        
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                if (is_array($array[$key])) {
                    $array[$key] = self::arrayReplace($array[$key], $find, $replace);
                } else {
                    if ($key === $find) {
                            $array[$key] = $replace;
                    }
                }
            }
        }
        return $array;
    }
    
    /**
     * Method getParentByValue Busca una cadena/valor en un array multidimensional
     *                         Devuelve como resultado los padres desde root hasta
     *                         la posicion en la que se encuentra el dato. 
     *
     * @param array  $array  Origen de datos
     * @param string $needle Cadena/Valor a buscar
     * @param array  $parent Array por referencia retorna el resultado
     *
     * @return void
     */
    public static function getParentByValue(
        array $array,
        string $needle,
        array &$parent
    ) {
        foreach ($array as $key => $value) {
            if ($value == $needle || is_array($value) 
                && self::getParentByValue($value, $needle, $parent)
            ) {
                array_unshift($parent, $key);
                return true;
            }
        }
        return false;
    }
}
