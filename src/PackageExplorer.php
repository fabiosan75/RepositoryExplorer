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

require_once __DIR__.'/../vendor/autoload.php';

//use Directory;
use RepositoryExplorer\ComposerReader;
use RepositoryExplorer\PackageNode;
use RepositoryExplorer\Interfaces\DirectoryReaderInterface;
use RepositoryExplorer\Util\ArrayUtil;

/**
 * Class PackageExplorer : Implementa los metodos para la valiacion del reposotorio
 *                         del proyecto y las dependencias.
 * 
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class PackageExplorer
{
    protected $package;
    public $dirReader;
    
    /**
     * Method __construct
     *
     * @param DirectoryReaderInterface $dirReaderI [explicite description]
     *
     * @return void
     */
    public function __construct(DirectoryReaderInterface $dirReaderI)
    {
        $this->dirReader = $dirReaderI;
    }
    
    /**
     * Method listRepository  Devuelve de la instancia DirectoryReader que 
     *                        contiene el repositorio 
     *                        todos los composer.json contenidos en el src/Path
     *  
     * @return array
     */
    public function listRepository(): array
    {
        return $this->dirReader->listDir('composer.json');
    }
    
    /**
     * Method getSchemaTree Obtiene la estructura en forma de arbol grafico
     *                      del Schema de un composer.json
     * 
     * @param array $repositoryFiles Lista de archivos composer.json
     *
     * @return  array
     * @example Representacion en arbol del SCHEMA de cada 
     *  array($packageName =>
     *    |_name : fabiosan75/libreria2
     *         |_description : Libreria 2 Prueba Dependencia Librerias CI/CD
     *         |_type : library
     *         |_license : proprietary
     *         |_repositories
     *           |_0
     *               |_type : vcs
     *               |_url : https://github.com/fabiosan75/libreria4
     *         |_autoload
     *           |_psr-4
     *               |_Fabiosan75\Libreria2\ : src/
     *   )
     */
    public static function getSchemaTree(array $repositoryFiles):array
    {
        $treeSchema = [];
        foreach ($repositoryFiles as $fileComposer) {

            $fileReader = new FileReader($fileComposer);
            $composerReader = new ComposerReader($fileReader);

            $packageName = $composerReader->getAttribute('name');
            $jsonSchema = $composerReader->getSchema();

            $packages[$packageName] = new PackageNode($composerReader);
            $treeSchema[$packageName] = ArrayUtil::treeView($jsonSchema, 1);

        }
        return array($treeSchema,$packages);
    }
    
    /**
     * Method getRequire Genera arreglo de dependencias del repositorio
     *
     * @param array $repoSchemas Array objetos PackageNode
     *
     * @return array
     */
    public static function getRequire(array $repoSchemas):array 
    {
        $treeArray =  [];
        $requirelib = [];

        foreach ($repoSchemas[1] as $packageName => $packageObj) {

            $require = []; 
            $pckType = $packageObj->getType();

            foreach ($packageObj->getRequire() as $reqPackage => $reqData) {
                if ($pckType === 'project') {
                    $treeArray[$packageName][$reqPackage] = $reqPackage;
                } else {
                    $requirelib[$packageName][$reqPackage] = $reqPackage;
                }
            }

        }

        // Valdiar si la dependencia existe en el proyecto y agregarla
        // a la rama en la correspondiente posicion 

        foreach ($requirelib as $reqPackage => $require) {
            $treeArray = ArrayUtil::arrayReplace(
                $treeArray, 
                $reqPackage, 
                $require
            );        
        }

        return $treeArray;
    }
}

/*
$file = $argv[1];

$dirReader = new DirectoryReader($file); 

$pckExplorer = new PackageExplorer($dirReader);

$listComposerFiles = $pckExplorer->listRepository();

$repoSchemas = $pckExplorer::getSchemaTree($listComposerFiles);
//print_r($repoSchemas);

$treeArray = $pckExplorer::getRequire($repoSchemas);
print_r($treeArray);


foreach ($treeArray as $project => $tree) {
    $parent = [];
    ArrayUtil::getParentByValue($tree, 'fabiosan75/libreria1', $parent);
    if (!empty($parent)) {
        $parent[] = $project;
        print_r(($parent));
    }
}
*/


//echo ArrayUtil::treeView($treeArray, 1);



