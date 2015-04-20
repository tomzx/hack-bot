<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'unalias',
	'command' => 'unalias',
	'parameters' => '(?<command>\S+)',
	'help' => 'command',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		// TODO: Check if target command exist?
		$dataDirectory = 'data';
		$dataFile = $dataDirectory.'/alias.json';

		$command = $data['command'];

		$aliases = [];
		// TODO: Have a caching system so we don't read the file every time?
		if (file_exists($dataFile)) {
			$aliases = json_decode(file_get_contents($dataFile), true);
		}

		if ( ! array_key_exists($command, $aliases)) {
			return $command.' is not a know alias.';
		}

		unset($aliases[$command]);

		file_put_contents($dataFile, json_encode($aliases, JSON_PRETTY_PRINT));

		return 'Alias "'.$command.'" removed!';
	}
];