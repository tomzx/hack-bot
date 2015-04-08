<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'alias',
	'command' => 'alias',
	'parameters' => '(?<new_command>[^ ]+)(?<command>[^ ]+)( (?<args>.*))?',
	'help' => 'newcommand command <args>',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		return 'alias';
	}
];