<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'info',
	'command' => 'info',
	'parameters' => '',
	'help' => '',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		return 'info';
	}
];