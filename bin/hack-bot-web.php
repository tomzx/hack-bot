<?hh // strict

use tomzx\HackBot\Adapters\Web;
use tomzx\HackBot\Core\Logger;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Request;

require __DIR__.'/../vendor/autoload.php';


// TODO: Move to a logger which doesn't echo
Logger::setEnabled(false);

$dispatcher = new Dispatcher();
$dispatcher->initializeResponders();

$web = new Web();
$web->setDispatcher($dispatcher);
$web->run();
