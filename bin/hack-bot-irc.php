<?hh // strict

use tomzx\HackBot\Adapters\IRC;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Request;

require 'vendor/autoload.php';

$configuration = [
	'server' => 'irc.freenode.net',
	'port' => 6667,
	'nick' => 'hack-bot',
	'real_name' => 'hack-bot',
	'password' => '',
	'channels' => [
	],
];

$dispatcher = new Dispatcher();
$dispatcher->initializeResponders();

$irc = new IRC($configuration);
$irc->setDispatcher($dispatcher);
$irc->run();