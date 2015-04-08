<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'help',
	'command' => 'help',
	'parameters' => '',
	'help' => '',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$responders = $dispatcher->getResponders();
		return implode(', ', array_keys($responders));
	}
];