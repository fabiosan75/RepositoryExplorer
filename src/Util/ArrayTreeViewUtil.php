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
 *  ArrayTreeViewUtil  Genera una vista de arbol de un array 
 *                     asociativo multidimensional, retorna string
 *                     con la representación en forma de arbol
 *                        |padre : valor
 *                              |_nodo : valor
 *                                  |_nodo : valor
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */
class ArrayTreeViewUtil
{
    /**
     * Method iterateArray Recorre de forma recursiva un array 
     *                     asociativo multidimensional, retorna 
     *                     string con la representación |_ 
     *
     * @param array $data  Array asociativo 
     * @param int   $level Nivel inicial default 1
     *
     * @return string
     */
    public static function iterate(array $data,int $level): string 
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
                $next = self::iterate($value, ($level+1));
                $branch = $branch.$spaces."|_".$key.PHP_EOL.$next;
            }
        }
        return $branch;


    }
    
}
