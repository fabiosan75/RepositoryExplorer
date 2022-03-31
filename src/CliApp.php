#!/usr/local/bin/php
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
use GetTreeRepository\CliConfig;
use GetTreeRepository\PackageExplorer;
use GetTreeRepository\Util\CliMsg;

/**
 * CLIClass Class 
 *            Implementa los metodos necesarios para el uso de la linea de comandos
 *            crea los parametros de linea de comando, valida opciones, genera los 
 *            mensajes por STDOUT según las opciones de entrada y parametros 
 *            entregados al comando.
 *
 * @category Class
 * @package  GetTreeRepository
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

class CliApp extends CliConfig
{
  
    /**
     * Method __construct
     *
     * @return void
     */
    function __construct()
    {
        try {
            if (!self::checkOS()) {
                throw new CliException(" APP implementada para Sistemas UIX");
            }
        } catch (CliException $e) {  
            echo $e->cliError();
            die();
        }

        $this->configureCli();

    }
    
    /**
     * Method run
     *
     * @return void
     */
    public function run():void 
    {

        echo CliMsg::colorText('EL cOMANDO', CliMsg::BLUE_TXTCOD);

        print_r(self::$options);
    
        try {
            if (empty(self::$options)) {
                throw new CliException(
                    'Ingrese una opción valida,'.
                    'por favor valide la ayuda [-u --usage -h --help]'
                );
            }

        } catch (CliException $e) {
            $e->cliError();
        }

        foreach (self::$options AS $option => $param) {  

            echo CliMsg::colorText(
                self::$optionDefs[$option][0], 
                CliMsg::GREEN_TXTCOD
            );

            switch($option) {
        
            case 'h':
            case 'help':
                    echo CliMsg::colorText(self::help(), CliMsg::GREEN_TXTCOD);
                break;
            case 'u':
            case 'usage':
                    echo CliMsg::colorText(self::usage(), CliMsg::BLUE_TXTCOD);
                break;
            case 'v':
            case "--version":
                  echo self::$MAN_FOOTER.PHP_EOL;
                break;
            case 'e':
            case 'explorer':

                if (!empty($param)) {
                    echo CliMsg::colorText(
                        " src : ".$param.PHP_EOL, 
                        CliMsg::GREEN_TXTCOD
                    );

                    $dirReader = new DirectoryReader($param);
                    $pckExplorer = new PackageExplorer($dirReader);
                    $composerFiles = $pckExplorer->listRepository($param);
                    $repoSchemas = $pckExplorer::getSchemaTree($composerFiles);
                    //  print_r($repoSchemas);

                    foreach ($repoSchemas as $repoName => $repoSchema) {

                        echo CliMsg::colorText(
                            " name : ".$repoName.PHP_EOL, 
                            CliMsg::GREEN_TXTCOD
                        );

                        echo CliMsg::colorText(
                            $repoSchema, CliMsg::BLUE_TXTCOD
                        );
                        
                        echo PHP_EOL; 
                    }
                    
                } else {
                    throw new CliException(
                        'src/Path no especificado. Verifique la ayuda (-h)'
                    );
                }

                break;
            case 's':
            case 'show':
  
                if (!empty($param)) {
                  
                    echo CliMsg::colorText(
                        " src/Path : ".$param.PHP_EOL, 
                        CliMsg::GREEN_TXTCOD
                    );
                     
                    $dirReader = new DirectoryReader($param); 
                    $files = $dirReader->listDir('composer.json');
                    echo $dirReader->show($files);

                } else {
                    throw new CliException(
                        'File/path is missing. Check help (-h) for correct usage '
                    );
                }
  
                break;
            case 'l' :
            case 'log' :
                $fileReader = new FileReader('log.txt');
                echo $fileReader->readFile();

                break;
            /*   $pckExplorer = new PackageExplorer();

                $listComposerFiles = $pckExplorer::listRepository($file);
                
                $pckExplorer::analizePckRepository($listComposerFiles);
            */
            }
        }

    }
   
}

// echo PHP_BINDIR;

$cli = new CliApp();
$cli->run();
//$cli->configureCli();

echo "ok";

