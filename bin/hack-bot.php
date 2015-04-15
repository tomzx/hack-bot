<?hh // strict

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Adapters\Shell;

require __DIR__.'/../vendor/autoload.php';

$dispatcher = new Dispatcher();
$dispatcher->initializeResponders();

$shell = new Shell();
$shell->setDispatcher($dispatcher);
$shell->run();