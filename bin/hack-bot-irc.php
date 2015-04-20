<?hh // strict

use tomzx\HackBot\Adapters\IRC;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Request;

require __DIR__.'/../vendor/autoload.php';

$configuration = [
	'server' => 'irc.freenode.net',
	'port' => 6667,
	'nick' => 'hack-bot',
	'real_name' => 'hack-bot',
	'password' => '',
	'channels' => [
	],
	'delay' => 0.5,
];

$dispatcher = new Dispatcher();
$dispatcher->initializeResponders();

$irc = new IRC($configuration);
$irc->setDispatcher($dispatcher);
$irc->run();