<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'alias',
	'command' => 'alias',
	'parameters' => '(?<new_command>\S+) (?<replacement>.+)',
	'help' => 'newcommand command <args>',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		// TODO: Check if target command exist?
		$dataDirectory = 'data';
		$dataFile = $dataDirectory.'/alias.json';

		$newCommand = $data['new_command'];
		$replacement = $data['replacement'];

		$aliases = [];
		// TODO: Have a caching system so we don't read the file every time?
		if (file_exists($dataFile)) {
			$aliases = json_decode(file_get_contents($dataFile), true);
		}

		if (array_key_exists($newCommand, $aliases)) {
			// TODO: Support a --force flag?
			return $newCommand.' already exist. Remove it before creating an alias.';
		}

		$aliases[$newCommand] = $replacement;

		file_put_contents($dataFile, json_encode($aliases, JSON_PRETTY_PRINT));

		return 'Alias added! '.$newCommand.' -> '.$replacement;
	}
];