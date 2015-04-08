<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'reload',
	'command' => 'reload',
	'parameters' => '(?<target>\S+|all)',
	'help' => 'plugin|all',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$dispatcher->reloadResponders();
		$targets = $data['target'];
		return 'reload? '.$targets;
	}
];