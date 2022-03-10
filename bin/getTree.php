<?php
//#!/usr/local/bin/php

$ignoreArray = array(
    '.', '..', '.git', 'composer','composer.lock',
    'vendor', 'src', 'README.md', '.gitignore', 'bin'
);

if (!posix_isatty(STDOUT)) {
    fwrite(STDOUT, "Invalid TTY\n");
    exit(2);
}

echo $argv[0] . PHP_EOL;
$path = $argv[1]; //'./';

if (!is_dir($path)) {
    throw new Exception('Ruta directorio no valida');
}

function listdir($dir, $pattern):array 
{
    $files = [];
    $fh = opendir($dir);

    while (($file = readdir($fh)) !== false) {
        if ($file == '.' || $file == '..')
            continue;

        $filepath = $dir . '/' . $file;

        if (is_dir($filepath))
            $files = array_merge($files, listdir($filepath, $pattern));
        else {
            if (preg_match($pattern, $file))
                $files[basename($dir)] = $file;
               // array_push($files, $filepath);
        }
    }
    closedir($fh);

    return $files;
}

$listFiles = graphicTree($path, 10, $ignoreArray);

print_r($listFiles);
exit;
$files = listdir($path, '/(composer.json)/');
print_r($files);
foreach ($files AS $dirName => $file) {
    echo $dirName . '=>' . $file . PHP_EOL;
}

exit;

$dir = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::SELF_FIRST);
while ($files->valid()) {
    $file = $files->current();
    $filename = $file->getFilename();
    $deep = $files->getDepth();
    $indent = str_repeat('│ ', $deep);
    $files->next();
    $valid = $files->valid();
    if ($valid and ($files->getDepth() - 1 == $deep or $files->getDepth() == $deep)) {
        echo $indent, "├ $filename\n";
    } else {
        echo $indent, "└ $filename\n";
    }
}
exit;
echo ($_SERVER["SCRIPT_NAME"]) . PHP_EOL;
echo $path . PHP_EOL . PHP_EOL;


//print_r($argc);

/*
$dir = new RecursiveDirectoryIterator($path);
$files = new RecursiveCallbackFilterIterator($dir, function($file, $key, $iterator) use ($ignoreArray){
    if($iterator->hasChildren() && !in_array($file->getFilename(), $ignoreArray)){
        return true;
    }
    return $file->isFile();
});
*/


//graphicTree($path, 10, $ignoreArray);

//$listFiles = listFolderFiles ($path,$ignoreArray);
//print_r($listFiles);

$tree = tree($path, $ignoreArray);
//print_r($tree);

function tree($path, $exclude = array()): array
{

    $files = array();
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $splfileinfo) {
        $fileName = basename($splfileinfo->getPathName());

        if (!in_array($fileName, $exclude)) {
            $files[] = str_replace($path, '', '' . $splfileinfo);
        }
    }
    return $files;
}


echo "Lista scandir ";
$ignoreArray = array(
    '.', '..', '.git',
    'vendor', 'src', 'README.md', '.gitignore', 'bin'
);
$files = scandir('./');
$files = array_diff($files, $ignoreArray);

foreach ($files as $file) {
    echo ("$file \n");
}


/**
 * Method listFolderFiles
 * Obtiene el listado recursivo de directorios/arvhivos contenidos
 * en el $path especificado
 * 
 * @param string $path [Ruta a directorio]
 * @param array $ignoreArray [Lista de archivos a excluir ej : (. ..)]
 *
 * @return array
 */
function listFolderFiles(string $path, array $ignoreArray): array
{
    // $arr = array();
    $ffs = scandir($path);

    $listFiles = array_diff($ffs, $ignoreArray);

    foreach ($listFiles as $ff) {
        $arr[$ff] = array();
        if (is_dir($path . '/' . $ff)) {
            $arr[$ff] = listFolderFiles($path . '/' . $ff, $ignoreArray);
        }
        // }
    }

    return $arr;
}


function graphicTree($basePath, int $root, $ignoreArray): array
{
    $path = '';
    $fileList = [];

    if (is_dir($basePath)) {

        $dir = opendir($basePath);

        while (($fileName = readdir($dir)) !== false) {

            if (!in_array(basename($fileName), $ignoreArray)) {
            //  echo basename($fileName);
                for ($i = 0; $i < $root; $i++) {
                    if ($i % 2 == 0 || $i == 0) {
                        printf("%c", '└'); //179 └ ├ │ ─
                    } else {
                        printf(" ");
                    }
                }

                printf("%s%s%s\n", '├', '──', $fileName);

                $path = $basePath . '/' . $fileName; // strcpy($path, $basePath);
             $fileList[] = $path;
            //  graphicTree($path, $root + 5, $ignoreArray);
                $fileList = array_merge($fileList, graphicTree($path, $root + 5, $ignoreArray));

            }
        }

        closedir($dir);
    }

    return $fileList;
}
