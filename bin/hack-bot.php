<?hh // strict

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Request;

require 'vendor/autoload.php';

$dispatcher = new Dispatcher();
$dispatcher->initializeResponders();

$query = implode(' ', array_slice($argv, 1));
$request = new Request();
$request->setRequest($query);

$response = $dispatcher->dispatch($request);
echo 'QUERY WAS: '.$query.PHP_EOL;
var_dump($response->hasResponse());
var_dump($response->getResponse());
