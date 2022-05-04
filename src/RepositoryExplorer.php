<?php

/**
 * #!/usr/local/bin/php
 * PHP version 7
 *
 * @category Class
 * @package  RepositoryExplorer
 * @author   fabiosan75 <fabiosan75@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/fabiosan75
 */

namespace RepositoryExplorer;

require_once __DIR__ . '/../vendor/autoload.php';

use RepositoryExplorer\CliApp;

$cli = new CliApp();
$cli->run();
