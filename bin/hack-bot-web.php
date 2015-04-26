<?hh // strict

use tomzx\HackBot\Adapters\Web;
use tomzx\HackBot\Core\Logger;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Request;

require __DIR__.'/../vendor/autoload.php';

// TODO: Provide a centralized location for code to refer to paths such as the data folder
chdir(__DIR__.'/..');

// TODO: Move to a logger which doesn't echo
Logger::setEnabled(false);

$dispatcher = new Dispatcher();
$dispatcher->initialize();

$web = new Web();
$web->setDispatcher($dispatcher);
$web->run();
